<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string("name"); //Ele já entende como um varchar 255. Por padrão Not NULL
            $table->text("description");//TEXT
            $table->unsignedSmallInteger("capacity");
            $table->timestamps(); //Cria duas colunas: Uma de criação do registro, outra de atualização do registro.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};
