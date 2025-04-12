<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageCompanyPermissionsTable extends Migration
{
    public function up()
    {
        schema::create('page_company_permissions', function (Blueprint $table) {
            $table->id();
            // Use o tipo correto aqui (provavelmente unsignedInteger)
            $table->unsignedInteger('page_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();
        
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        
            $table->unique(['page_id', 'company_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_company_permissions');
    }
}