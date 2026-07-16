<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE metas
            MODIFY status ENUM(
                'EM_ANDAMENTO',
                'CUMPRIDA',
                'PARCIAL',
                'NAO_CUMPRIDA'
            ) NOT NULL DEFAULT 'EM_ANDAMENTO'
        ");
    }

    public function down(): void
    {
        DB::table('metas')
            ->where('status', 'EM_ANDAMENTO')
            ->update(['status' => 'NAO_CUMPRIDA']);

        DB::statement("
            ALTER TABLE metas
            MODIFY status ENUM(
                'CUMPRIDA',
                'PARCIAL',
                'NAO_CUMPRIDA'
            ) NOT NULL DEFAULT 'NAO_CUMPRIDA'
        ");
    }
};