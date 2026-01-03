<?php

namespace App\Jobs;

use App\Mail\CampanaEmail;
use App\Models\EmailCampaign;
use App\Models\EmailLog;
use App\Models\FaithfulMember;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EnviarCampanaEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 3600; // 1 hora max

    public function __construct(
        public EmailCampaign $campana
    ) {}

    public function handle(): void
    {
        // Obtener destinatarios
        $destinatarios = $this->campana->obtenerDestinatarios()->get();

        if ($destinatarios->isEmpty()) {
            Log::warning("Campaña {$this->campana->id}: No hay destinatarios");
            return;
        }

        // Marcar como enviando
        $this->campana->marcarEnviando($destinatarios->count());

        // Crear logs para cada destinatario
        $this->crearLogs($destinatarios);

        // Procesar envíos
        $this->procesarEnvios();

        // Marcar como enviada
        $this->campana->marcarEnviada();

        Log::info("Campaña {$this->campana->id}: Envío completado. Enviados: {$this->campana->enviados}, Fallidos: {$this->campana->fallidos}");
    }

    protected function crearLogs($destinatarios): void
    {
        foreach ($destinatarios as $fiel) {
            EmailLog::create([
                'email_campaign_id' => $this->campana->id,
                'faithful_member_id' => $fiel->id,
                'email' => $fiel->email,
                'estado' => 'pendiente',
            ]);
        }
    }

    protected function procesarEnvios(): void
    {
        $logs = $this->campana->logs()->pendientes()->with('faithfulMember')->get();

        foreach ($logs as $log) {
            // Verificar si la campaña fue cancelada
            $this->campana->refresh();
            if ($this->campana->estado === 'cancelada') {
                Log::info("Campaña {$this->campana->id}: Cancelada durante el envío");
                return;
            }

            $this->enviarAFiel($log);

            // Pequeña pausa para no saturar el servidor de correo
            usleep(100000); // 100ms
        }
    }

    protected function enviarAFiel(EmailLog $log): void
    {
        $fiel = $log->faithfulMember;

        if (!$fiel || !$fiel->puedeRecibir('newsletter')) {
            $log->marcarFallido('El fiel no puede recibir emails');
            $this->campana->incrementarFallidos();
            return;
        }

        try {
            // Procesar contenido con variables
            $contenido = $this->procesarContenido($this->campana->contenido, $fiel);
            $asunto = $this->procesarAsunto($this->campana->asunto, $fiel);

            Mail::to($fiel->email)
                ->send(new CampanaEmail(
                    asunto: $asunto,
                    contenido: $contenido,
                    fiel: $fiel,
                    campana: $this->campana
                ));

            $log->marcarEnviado();
            $this->campana->incrementarEnviados();

        } catch (\Exception $e) {
            Log::error("Error enviando email a {$fiel->email}: " . $e->getMessage());
            $log->marcarFallido($e->getMessage());
            $this->campana->incrementarFallidos();
        }
    }

    protected function procesarContenido(string $contenido, FaithfulMember $fiel): string
    {
        $reemplazos = [
            '{{nombre}}' => $fiel->nombre,
            '{{apellidos}}' => $fiel->apellidos,
            '{{nombre_completo}}' => $fiel->nombre_completo,
            '{{email}}' => $fiel->email,
            '{{capilla}}' => $fiel->chapel?->nombre ?? 'Templo Parroquial',
            '{{fecha_actual}}' => now()->format('d/m/Y'),
            '{{nombre_parroquia}}' => config('app.name'),
        ];

        return str_replace(
            array_keys($reemplazos),
            array_values($reemplazos),
            $contenido
        );
    }

    protected function procesarAsunto(string $asunto, FaithfulMember $fiel): string
    {
        $reemplazos = [
            '{{nombre}}' => $fiel->nombre,
            '{{nombre_completo}}' => $fiel->nombre_completo,
            '{{fecha_actual}}' => now()->format('d/m/Y'),
        ];

        return str_replace(
            array_keys($reemplazos),
            array_values($reemplazos),
            $asunto
        );
    }

    public function failed(\Throwable $exception): void
    {
        Log::error("Job EnviarCampanaEmail falló para campaña {$this->campana->id}: " . $exception->getMessage());

        // Marcar la campaña con error si falló completamente
        if ($this->campana->estado === 'enviando') {
            $this->campana->update(['estado' => 'enviada']);
        }
    }
}
