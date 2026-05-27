<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained()->onDelete('cascade');
            $table->foreignId('almacen_id')->constrained('almacenes')->onDelete('cascade');
            $table->integer('cantidad')->default(0);
            $table->timestamps();
            
            // Un producto no puede estar duplicado en el mismo almacén
            $table->unique(['producto_id', 'almacen_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventario');
    }
};