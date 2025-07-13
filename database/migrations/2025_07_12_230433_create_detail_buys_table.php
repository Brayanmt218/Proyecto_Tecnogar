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
        Schema::create('detail_buys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('buy_id'); //Clave foranea para vinvukar con actegorias
            $table->foreign('buy_id')
                ->references('id')
                ->on('buys')
                ->onDelete('cascade'); //Vincula cono la tabla categories , elimina productos si se borra la categoria
            // Relación con Proveedores
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->integer('stock'); //Nombre del producto
            $table->decimal('price_unit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_buys');
    }
};
