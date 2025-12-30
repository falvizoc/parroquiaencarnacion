<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OptimizarProduccion extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'app:optimizar
                            {--clear : Limpiar cachés antes de optimizar}';

    /**
     * The console command description.
     */
    protected $description = 'Optimiza la aplicación para producción (cachés, rutas, vistas)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🚀 Optimizando aplicación para producción...');
        $this->newLine();

        // Limpiar cachés si se solicita
        if ($this->option('clear')) {
            $this->warn('Limpiando cachés existentes...');
            $this->call('cache:clear');
            $this->call('config:clear');
            $this->call('route:clear');
            $this->call('view:clear');
            $this->newLine();
        }

        // Optimizar configuración
        $this->info('📦 Cacheando configuración...');
        $this->call('config:cache');

        // Optimizar rutas
        $this->info('🛣️  Cacheando rutas...');
        $this->call('route:cache');

        // Optimizar vistas
        $this->info('👁️  Cacheando vistas...');
        $this->call('view:cache');

        // Optimizar eventos
        $this->info('📡 Cacheando eventos...');
        $this->call('event:cache');

        // Storage link
        $this->info('🔗 Verificando storage link...');
        if (!file_exists(public_path('storage'))) {
            $this->call('storage:link');
        } else {
            $this->line('   Storage link ya existe.');
        }

        $this->newLine();
        $this->info('✅ Optimización completada.');
        $this->table(
            ['Caché', 'Estado'],
            [
                ['Configuración', '✓ Cacheada'],
                ['Rutas', '✓ Cacheadas'],
                ['Vistas', '✓ Cacheadas'],
                ['Eventos', '✓ Cacheados'],
                ['Storage', '✓ Enlazado'],
            ]
        );

        $this->newLine();
        $this->comment('Recuerda ejecutar "npm run build" para compilar assets de producción.');

        return Command::SUCCESS;
    }
}
