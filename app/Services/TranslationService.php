<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\TranslationLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class TranslationService
{
    /**
     * Contexto del sitio para traducciones más precisas.
     */
    protected string $contexto = 'Este es contenido de una parroquia católica en México.
        Mantener terminología religiosa apropiada y tono formal pero acogedor.
        Nombres propios, lugares y referencias locales mexicanas no deben traducirse.
        Usar vocabulario católico correcto en inglés (Mass, Holy Communion, Confession, etc.).';

    /**
     * Traduce campos específicos de un modelo.
     */
    public function traducirModelo(Model $modelo, array $campos = []): void
    {
        // Si no se especifican campos, usar todos los traducibles
        if (empty($campos)) {
            $campos = $modelo->getTranslatableAttributes();
        }

        foreach ($campos as $campo) {
            $this->traducirCampo($modelo, $campo);
        }

        // Guardar sin disparar eventos (evita loop infinito)
        $modelo->saveQuietly();
    }

    /**
     * Traduce un campo específico de un modelo.
     */
    protected function traducirCampo(Model $modelo, string $campo): void
    {
        $textoOriginal = $modelo->getTranslation($campo, 'es');

        if (empty($textoOriginal)) {
            return;
        }

        // Verificar si ya existe traducción y fue editada manualmente
        $traduccionExistente = $modelo->getTranslation($campo, 'en');
        if (!empty($traduccionExistente) && ($modelo->translation_manually_edited ?? false)) {
            return;
        }

        $log = $this->crearLog($modelo, $campo, $textoOriginal);

        try {
            $log->update(['status' => 'processing']);

            $traduccion = $this->traducirTexto($textoOriginal, $campo);

            $modelo->setTranslation($campo, 'en', $traduccion);

            $log->update([
                'translated_text' => $traduccion,
                'status' => 'completed',
            ]);

            Log::info('Traducción completada', [
                'modelo' => get_class($modelo),
                'id' => $modelo->id,
                'campo' => $campo,
            ]);
        } catch (\Exception $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);

            Log::error('Error al traducir contenido', [
                'modelo' => get_class($modelo),
                'id' => $modelo->id,
                'campo' => $campo,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Traduce un texto individual usando OpenAI.
     */
    public function traducirTexto(string $texto, string $tipoCampo = 'general'): string
    {
        // Verificar si la integración está activa
        if (!$this->estaActivo()) {
            throw new \Exception('La integración de IA no está activa. Configúrala en Admin > Integraciones.');
        }

        // Limpiar texto de HTML excesivo si es necesario
        $textoLimpio = $this->prepararTextoParaTraduccion($texto);

        // Obtener modelo configurado o usar por defecto
        $modelo = Setting::obtener('ia_modelo', 'gpt-4o-mini');

        // Obtener cliente de OpenAI (usa API Key de settings o .env)
        $client = $this->obtenerCliente();

        $response = $client->chat()->create([
            'model' => $modelo,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $this->obtenerPromptSistema($tipoCampo),
                ],
                [
                    'role' => 'user',
                    'content' => $this->construirPrompt($textoLimpio, $tipoCampo),
                ],
            ],
            'temperature' => 0.3,
            'max_tokens' => 4096,
        ]);

        return trim($response->choices[0]->message->content);
    }

    /**
     * Verifica si la integración de IA está activa.
     */
    public function estaActivo(): bool
    {
        return (bool) Setting::obtener('ia_activo', false);
    }

    /**
     * Obtiene el cliente de OpenAI con la API Key del dashboard.
     */
    protected function obtenerCliente()
    {
        $apiKey = Setting::obtener('ia_api_key');

        if (empty($apiKey)) {
            throw new \Exception('API Key no configurada. Ve a Admin > Integraciones > Inteligencia Artificial.');
        }

        return \OpenAI::factory()
            ->withApiKey($apiKey)
            ->make();
    }

    /**
     * Prepara el texto para traducción.
     */
    protected function prepararTextoParaTraduccion(string $texto): string
    {
        // Si el texto es muy largo, no hacer nada especial
        // OpenAI puede manejar HTML
        return $texto;
    }

    /**
     * Obtiene el prompt de sistema según el tipo de campo.
     */
    protected function obtenerPromptSistema(string $tipoCampo): string
    {
        $base = "Eres un traductor profesional especializado en contenido religioso católico.
                 Traduces del español al inglés manteniendo el tono pastoral y acogedor.
                 {$this->contexto}

                 REGLAS IMPORTANTES:
                 - Responde ÚNICAMENTE con la traducción, sin explicaciones
                 - Preserva el formato HTML si existe
                 - Mantén la misma estructura y párrafos
                 - No traduzcas nombres propios de personas
                 - No traduzcas nombres de lugares mexicanos (colonias, calles, ciudades)";

        $instruccionesEspecificas = match ($tipoCampo) {
            'titulo', 'nombre' => 'Traduce títulos de manera concisa y atractiva. Usar mayúsculas según reglas del inglés.',
            'slug' => 'Genera un slug en inglés: solo minúsculas, guiones en lugar de espacios, sin acentos ni caracteres especiales. Solo el slug, sin comillas.',
            'contenido', 'descripcion', 'biografia', 'mensaje' => 'Traduce el contenido completo preservando el formato HTML. Mantener párrafos y estructura.',
            'extracto', 'descripcion_corta' => 'Traduce de manera concisa, ideal para previsualización. Máximo 2-3 oraciones.',
            'lugar', 'direccion', 'lugar_reunion' => 'Traduce términos generales (Calle→Street, Colonia→Neighborhood) pero mantener nombres propios.',
            'cargo', 'titulo' => 'Usar terminología eclesiástica correcta: Párroco→Pastor, Vicario→Vicar, Padre→Fr., Monseñor→Msgr.',
            'asunto' => 'Traducir como línea de asunto de email: claro, conciso y llamativo.',
            default => 'Traduce de manera natural y fluida.',
        };

        return "{$base}\n\nInstrucciones específicas para este campo ({$tipoCampo}): {$instruccionesEspecificas}";
    }

    /**
     * Construye el prompt de traducción.
     */
    protected function construirPrompt(string $texto, string $tipoCampo): string
    {
        return "Traduce el siguiente texto del español al inglés:\n\n{$texto}";
    }

    /**
     * Crea un registro de log para la traducción.
     */
    protected function crearLog(Model $modelo, string $campo, string $textoOriginal): TranslationLog
    {
        return TranslationLog::create([
            'translatable_type' => get_class($modelo),
            'translatable_id' => $modelo->id,
            'field' => $campo,
            'source_locale' => 'es',
            'target_locale' => 'en',
            'source_text' => $textoOriginal,
            'status' => 'pending',
        ]);
    }

    /**
     * Traduce todos los registros pendientes de un modelo.
     */
    public function traducirPendientes(string $modelClass, int $limite = 100): int
    {
        $traducidos = 0;
        $modelo = new $modelClass();

        if (!method_exists($modelo, 'getTranslatableAttributes')) {
            return 0;
        }

        $registros = $modelClass::query()
            ->where('translation_manually_edited', false)
            ->limit($limite)
            ->get();

        foreach ($registros as $registro) {
            if (!$registro->tieneTraduccionIngles()) {
                $this->traducirModelo($registro);
                $traducidos++;
            }
        }

        return $traducidos;
    }
}
