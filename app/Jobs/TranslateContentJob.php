<?php

namespace App\Jobs;

use App\Services\TranslationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TranslateContentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Número de intentos antes de fallar.
     */
    public int $tries = 3;

    /**
     * Segundos a esperar entre reintentos.
     */
    public int $backoff = 60;

    /**
     * Timeout del job en segundos.
     */
    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Model $modelo,
        protected array $campos = []
    ) {
        // Usar cola específica para traducciones
        $this->onQueue('translations');
    }

    /**
     * Execute the job.
     */
    public function handle(TranslationService $translationService): void
    {
        Log::info('Iniciando traducción', [
            'modelo' => get_class($this->modelo),
            'id' => $this->modelo->id,
            'campos' => $this->campos,
        ]);

        $translationService->traducirModelo($this->modelo, $this->campos);

        Log::info('Traducción completada', [
            'modelo' => get_class($this->modelo),
            'id' => $this->modelo->id,
        ]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Job de traducción fallido definitivamente', [
            'modelo' => get_class($this->modelo),
            'id' => $this->modelo->id,
            'campos' => $this->campos,
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString(),
        ]);
    }

    /**
     * Get the tags that should be assigned to the job.
     */
    public function tags(): array
    {
        return [
            'translation',
            get_class($this->modelo),
            'model:' . $this->modelo->id,
        ];
    }
}
