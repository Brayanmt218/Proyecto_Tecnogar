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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Relación con Categorías
            $table->unsignedBigInteger('category_id');//Clave foranea para vinvukar con actegorias
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');//Vincula cono la tabla categories , elimina productos si se borra la categoria
            // Relación con Proveedores
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')
                ->references('id')
                ->on('providers')
                ->onDelete('cascade');
    
            $table->string('name');//Nombre del producto
            $table->text('description')->nullable();// opcional
            $table->string('nro_serie')->unique();
            $table->double('precio_venta');
            $table->double('precio_compra');
            $table->integer('stock');
            $table->integer('stock_minimo');
            $table->boolean('status')->default(true); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
