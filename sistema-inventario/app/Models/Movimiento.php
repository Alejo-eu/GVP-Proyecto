<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo', 'producto_id', 'cantidad', 
        'almacen_origen_id', 'almacen_destino_id',
        'observaciones', 'referencia', 'usuario_id'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function almacenOrigen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_origen_id');
    }

    public function almacenDestino()
    {
        return $this->belongsTo(Almacen::class, 'almacen_destino_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}