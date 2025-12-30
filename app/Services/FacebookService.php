<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookService
{
    protected const API_VERSION = 'v18.0';
    protected const BASE_URL = 'https://graph.facebook.com';

    protected ?string $appId = null;
    protected ?string $appSecret = null;
    protected ?string $pageId = null;
    protected ?string $accessToken = null;

    public function __construct()
    {
        $this->cargarCredenciales();
    }

    /**
     * Cargar credenciales desde la base de datos.
     */
    protected function cargarCredenciales(): void
    {
        $this->appId = Setting::obtener('facebook_app_id');
        $this->appSecret = Setting::obtener('facebook_app_secret');
        $this->pageId = Setting::obtener('facebook_page_id');
        $this->accessToken = Setting::obtener('facebook_access_token');
    }

    /**
     * Verificar si la integración está activa.
     */
    public function estaActivo(): bool
    {
        return (bool) Setting::obtener('facebook_activo', false);
    }

    /**
     * Verificar si las credenciales están configuradas.
     */
    public function estaConfigurado(): bool
    {
        return !empty($this->appId)
            && !empty($this->appSecret)
            && !empty($this->pageId)
            && !empty($this->accessToken);
    }

    /**
     * Probar la conexión con Facebook.
     */
    public function probarConexion(): array
    {
        if (!$this->estaConfigurado()) {
            return [
                'exito' => false,
                'error' => 'Credenciales incompletas',
            ];
        }

        try {
            $response = Http::get($this->construirUrl("/{$this->pageId}"), [
                'access_token' => $this->accessToken,
                'fields' => 'id,name,fan_count',
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'exito' => true,
                    'nombre_pagina' => $data['name'] ?? 'Desconocido',
                    'page_id' => $data['id'] ?? null,
                    'seguidores' => $data['fan_count'] ?? 0,
                ];
            }

            $error = $response->json('error.message', 'Error desconocido');
            return [
                'exito' => false,
                'error' => $error,
            ];
        } catch (\Exception $e) {
            Log::error('FacebookService: Error al probar conexión', [
                'error' => $e->getMessage(),
            ]);

            return [
                'exito' => false,
                'error' => 'Error de conexión: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Obtener publicaciones recientes de la página.
     */
    public function obtenerPublicaciones(int $limite = 10): array
    {
        if (!$this->estaActivo() || !$this->estaConfigurado()) {
            return [];
        }

        try {
            $response = Http::get($this->construirUrl("/{$this->pageId}/posts"), [
                'access_token' => $this->accessToken,
                'fields' => 'id,message,created_time,full_picture,permalink_url,shares,reactions.summary(true)',
                'limit' => $limite,
            ]);

            if ($response->successful()) {
                return $response->json('data', []);
            }

            Log::warning('FacebookService: Error al obtener publicaciones', [
                'error' => $response->json('error.message'),
            ]);

            return [];
        } catch (\Exception $e) {
            Log::error('FacebookService: Excepción al obtener publicaciones', [
                'error' => $e->getMessage(),
            ]);

            return [];
        }
    }

    /**
     * Obtener información de la página.
     */
    public function obtenerInfoPagina(): ?array
    {
        if (!$this->estaActivo() || !$this->estaConfigurado()) {
            return null;
        }

        try {
            $response = Http::get($this->construirUrl("/{$this->pageId}"), [
                'access_token' => $this->accessToken,
                'fields' => 'id,name,about,fan_count,cover,picture',
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('FacebookService: Error al obtener info de página', [
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Construir URL de la API de Facebook.
     */
    protected function construirUrl(string $endpoint): string
    {
        return self::BASE_URL . '/' . self::API_VERSION . $endpoint;
    }

    /**
     * Refrescar credenciales desde la base de datos.
     */
    public function refrescarCredenciales(): void
    {
        Setting::limpiarCache();
        $this->cargarCredenciales();
    }
}
