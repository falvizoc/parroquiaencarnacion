<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Modelos y campos a hacer traducibles.
     */
    protected array $translatableFields = [
        'news' => ['titulo', 'slug', 'extracto', 'contenido'],
        'events' => ['titulo', 'slug', 'descripcion_corta', 'descripcion', 'lugar', 'direccion'],
        'parish_groups' => ['nombre', 'slug', 'descripcion_corta', 'descripcion', 'lugar_reunion'],
        'chapels' => ['nombre', 'slug', 'descripcion', 'direccion'],
        'priests' => ['nombre', 'slug', 'cargo', 'titulo', 'mensaje', 'biografia'],
        'email_templates' => ['nombre', 'asunto', 'contenido'],
    ];

    /**
     * Índices únicos que deben eliminarse antes de modificar columnas.
     */
    protected array $uniqueIndexes = [
        'news' => ['slug' => 'news_slug_unique'],
        'events' => ['slug' => 'events_slug_unique'],
        'parish_groups' => ['slug' => 'parish_groups_slug_unique'],
        'chapels' => ['slug' => 'chapels_slug_unique'],
        'priests' => ['slug' => 'priests_slug_unique'],
        'email_templates' => ['slug' => 'email_templates_slug_unique'],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $isSqlite = DB::connection()->getDriverName() === 'sqlite';

        foreach ($this->translatableFields as $table => $fields) {
            // Verificar que la tabla existe
            if (!Schema::hasTable($table)) {
                continue;
            }

            if ($isSqlite) {
                // Para SQLite: reconstruir toda la tabla
                $this->migrateTableSqlite($table, $fields);
            } else {
                // Para MySQL/PostgreSQL: modificar columnas directamente
                $this->migrateTableStandard($table, $fields);
            }

            // Agregar campo para marcar si la traducción fue editada manualmente
            if (!Schema::hasColumn($table, 'translation_manually_edited')) {
                Schema::table($table, function (Blueprint $tableSchema) {
                    $tableSchema->boolean('translation_manually_edited')->default(false);
                });
            }
        }
    }

    /**
     * Migrar tabla usando método estándar (MySQL/PostgreSQL).
     */
    protected function migrateTableStandard(string $table, array $fields): void
    {
        foreach ($fields as $field) {
            if (!Schema::hasColumn($table, $field)) {
                continue;
            }

            // 1. Eliminar índice único si existe (para slugs)
            if (isset($this->uniqueIndexes[$table][$field])) {
                try {
                    Schema::table($table, function (Blueprint $tableSchema) use ($table, $field) {
                        $tableSchema->dropUnique($this->uniqueIndexes[$table][$field]);
                    });
                } catch (\Exception $e) {
                    // Índice puede no existir
                }
            }

            // 2. Agregar columna temporal JSON
            Schema::table($table, function (Blueprint $tableSchema) use ($field) {
                $tableSchema->json("{$field}_translatable")->nullable();
            });

            // 3. Migrar datos existentes al formato JSON (solo español)
            DB::table($table)->orderBy('id')->chunk(100, function ($records) use ($table, $field) {
                foreach ($records as $record) {
                    $value = $record->$field;
                    if ($value !== null && $value !== '') {
                        DB::table($table)
                            ->where('id', $record->id)
                            ->update([
                                "{$field}_translatable" => json_encode(['es' => $value], JSON_UNESCAPED_UNICODE),
                            ]);
                    }
                }
            });

            // 4. Eliminar columna original
            Schema::table($table, function (Blueprint $tableSchema) use ($field) {
                $tableSchema->dropColumn($field);
            });

            // 5. Renombrar columna JSON a nombre original
            Schema::table($table, function (Blueprint $tableSchema) use ($field) {
                $tableSchema->renameColumn("{$field}_translatable", $field);
            });
        }
    }

    /**
     * Migrar tabla usando método para SQLite (recrear tabla completa).
     */
    protected function migrateTableSqlite(string $table, array $fields): void
    {
        // Obtener todos los registros actuales
        $records = DB::table($table)->get();

        // Obtener información de la estructura actual de la tabla
        $columns = DB::select("PRAGMA table_info({$table})");
        $foreignKeys = DB::select("PRAGMA foreign_key_list({$table})");

        // Preparar datos convertidos
        $convertedRecords = [];
        foreach ($records as $record) {
            $recordArray = (array) $record;
            foreach ($fields as $field) {
                if (isset($recordArray[$field]) && $recordArray[$field] !== null && $recordArray[$field] !== '') {
                    $recordArray[$field] = json_encode(['es' => $recordArray[$field]], JSON_UNESCAPED_UNICODE);
                } else {
                    $recordArray[$field] = null;
                }
            }
            $convertedRecords[] = $recordArray;
        }

        // Renombrar tabla actual
        DB::statement("ALTER TABLE {$table} RENAME TO {$table}_old");

        // Crear nueva tabla con estructura modificada
        $this->createNewTable($table, $columns, $fields, $foreignKeys);

        // Insertar datos convertidos
        foreach ($convertedRecords as $record) {
            DB::table($table)->insert($record);
        }

        // Eliminar tabla antigua
        Schema::dropIfExists("{$table}_old");
    }

    /**
     * Crear nueva tabla con campos JSON para SQLite.
     */
    protected function createNewTable(string $table, array $columns, array $jsonFields, array $foreignKeys): void
    {
        Schema::create($table, function (Blueprint $tableSchema) use ($columns, $jsonFields, $foreignKeys, $table) {
            foreach ($columns as $column) {
                $name = $column->name;
                $type = strtolower($column->type);
                $notNull = (bool) $column->notnull;
                $default = $column->dflt_value;
                $isPk = (bool) $column->pk;

                // Para campos traducibles, usar JSON
                if (in_array($name, $jsonFields)) {
                    $tableSchema->json($name)->nullable();
                    continue;
                }

                // Mapear tipos SQLite a métodos de Schema
                if ($isPk && $name === 'id') {
                    $tableSchema->id();
                } elseif (str_contains($type, 'int')) {
                    $col = $tableSchema->integer($name)->unsigned(str_contains($type, 'unsigned'));
                    if (!$notNull) $col->nullable();
                    if ($default !== null) $col->default($default);
                } elseif (str_contains($type, 'varchar') || $type === 'text' || $type === 'string') {
                    $col = $tableSchema->text($name);
                    if (!$notNull) $col->nullable();
                    if ($default !== null) $col->default($default);
                } elseif ($type === 'boolean' || $type === 'tinyint(1)') {
                    $col = $tableSchema->boolean($name);
                    if (!$notNull) $col->nullable();
                    if ($default !== null) $col->default($default === '1' || $default === 'true');
                } elseif (str_contains($type, 'datetime') || str_contains($type, 'timestamp')) {
                    $col = $tableSchema->timestamp($name);
                    if (!$notNull) $col->nullable();
                } elseif (str_contains($type, 'date')) {
                    $col = $tableSchema->date($name);
                    if (!$notNull) $col->nullable();
                } elseif (str_contains($type, 'decimal') || str_contains($type, 'numeric')) {
                    $col = $tableSchema->decimal($name, 10, 2);
                    if (!$notNull) $col->nullable();
                } elseif (str_contains($type, 'json')) {
                    $col = $tableSchema->json($name);
                    if (!$notNull) $col->nullable();
                } else {
                    // Por defecto, usar text
                    $col = $tableSchema->text($name);
                    if (!$notNull) $col->nullable();
                }
            }

            // Agregar foreign keys
            foreach ($foreignKeys as $fk) {
                $tableSchema->foreign($fk->from)
                    ->references($fk->to)
                    ->on($fk->table)
                    ->onDelete($fk->on_delete ?? 'cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $isSqlite = DB::connection()->getDriverName() === 'sqlite';

        foreach ($this->translatableFields as $table => $fields) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            if ($isSqlite) {
                $this->rollbackTableSqlite($table, $fields);
            } else {
                $this->rollbackTableStandard($table, $fields);
            }

            // Eliminar campo de edición manual
            if (Schema::hasColumn($table, 'translation_manually_edited')) {
                Schema::table($table, function (Blueprint $tableSchema) {
                    $tableSchema->dropColumn('translation_manually_edited');
                });
            }
        }
    }

    /**
     * Rollback estándar para MySQL/PostgreSQL.
     */
    protected function rollbackTableStandard(string $table, array $fields): void
    {
        foreach ($fields as $field) {
            if (!Schema::hasColumn($table, $field)) {
                continue;
            }

            // 1. Agregar columna temporal de texto
            Schema::table($table, function (Blueprint $tableSchema) use ($field) {
                $tableSchema->longText("{$field}_text")->nullable();
            });

            // 2. Extraer contenido en español del JSON
            DB::table($table)->orderBy('id')->chunk(100, function ($records) use ($table, $field) {
                foreach ($records as $record) {
                    $jsonValue = $record->$field;
                    if ($jsonValue) {
                        $decoded = json_decode($jsonValue, true);
                        $textValue = $decoded['es'] ?? null;
                        DB::table($table)
                            ->where('id', $record->id)
                            ->update(["{$field}_text" => $textValue]);
                    }
                }
            });

            // 3. Eliminar columna JSON
            Schema::table($table, function (Blueprint $tableSchema) use ($field) {
                $tableSchema->dropColumn($field);
            });

            // 4. Renombrar columna de texto
            Schema::table($table, function (Blueprint $tableSchema) use ($field) {
                $tableSchema->renameColumn("{$field}_text", $field);
            });

            // 5. Recrear índice único si era un slug
            if (isset($this->uniqueIndexes[$table][$field])) {
                Schema::table($table, function (Blueprint $tableSchema) use ($field) {
                    $tableSchema->unique($field);
                });
            }
        }
    }

    /**
     * Rollback para SQLite (simplificado).
     */
    protected function rollbackTableSqlite(string $table, array $fields): void
    {
        // Para SQLite, extraer español del JSON y guardarlo como texto
        foreach ($fields as $field) {
            if (!Schema::hasColumn($table, $field)) {
                continue;
            }

            DB::table($table)->orderBy('id')->chunk(100, function ($records) use ($table, $field) {
                foreach ($records as $record) {
                    $jsonValue = $record->$field;
                    if ($jsonValue) {
                        $decoded = json_decode($jsonValue, true);
                        $textValue = $decoded['es'] ?? $jsonValue;
                        if ($textValue !== $jsonValue) {
                            DB::table($table)
                                ->where('id', $record->id)
                                ->update([$field => $textValue]);
                        }
                    }
                }
            });
        }
    }
};
