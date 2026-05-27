<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo', 'nombre', 'descripcion', 
        'precio_compra', 'precio_venta', 
        'stock_minimo', 'stock_maximo', 'activo'
    ];

    public function inventarios()
    {
        return $this->hasMany(Inventario::class);
    }

    public function almacenes()
    {
        return $this->belongsToMany(Almacen::class, 'inventario')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    public function getStockTotalAttribute()
    {
        return $this->inventarios()->sum('cantidad');
    }
}