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
        Schema::create('buys', function (Blueprint $table) {
            $table->id();
            // Relación con Categorías
            $table->unsignedBigInteger('user_id');//Clave foranea para vinvukar con actegorias
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');//Vincula cono la tabla categories , elimina productos si se borra la categoria
            // Relación con Proveedores
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onDelete('cascade');
    
            $table->date('date');//Nombre del producto
            $table->decimal('total');// opcional
            $table->string('voucher_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buys');
    }
};
