<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCompanyTable extends Migration
{
    public function up()
    {
        Schema::create('user_company', function (Blueprint $table) {
            $table->id();
            // Usando unsignedInteger em vez de unsignedBigInteger para corresponder ao tipo int unsigned
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');

            $table->unique(['user_id', 'company_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_company');
    }
}