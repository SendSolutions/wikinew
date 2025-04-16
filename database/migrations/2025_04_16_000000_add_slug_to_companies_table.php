<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddSlugToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            // Adiciona coluna slug se ainda não existir
            if (!Schema::hasColumn('companies', 'slug')) {
                $table->string('slug')->nullable()->after('name')->unique();
            }
        });
        
        // Preenche os slugs existentes baseados no nome
        DB::statement('UPDATE companies SET slug = LOWER(REPLACE(name, " ", "-"))');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}