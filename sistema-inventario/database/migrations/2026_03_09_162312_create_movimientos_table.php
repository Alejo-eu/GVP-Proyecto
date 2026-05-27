<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['entrada', 'salida', 'traslado']);
            $table->foreignId('producto_id')->constrained();
            $table->integer('cantidad');
            $table->foreignId('almacen_origen_id')->nullable()->constrained('almacenes');
            $table->foreignId('almacen_destino_id')->nullable()->constrained('almacenes');
            $table->text('observaciones')->nullable();
            $table->string('referencia')->nullable(); // Número de factura, guía, etc.
            $table->foreignId('usuario_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos');
    }
};