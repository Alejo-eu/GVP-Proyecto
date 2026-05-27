<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacenes';
    
    protected $fillable = [
        'nombre', 'ubicacion', 'descripcion', 'activo'
    ];

    public function inventarios()
    {
        return $this->hasMany(Inventario::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'inventario')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    public function movimientosOrigen()
    {
        return $this->hasMany(Movimiento::class, 'almacen_origen_id');
    }

    public function movimientosDestino()
    {
        return $this->hasMany(Movimiento::class, 'almacen_destino_id');
    }
}