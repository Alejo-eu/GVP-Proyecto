<?php
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\MovimientoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    
    Route::resource('almacenes', AlmacenController::class)->parameters([
        'almacenes' => 'almacen'
    ]);
    
    Route::prefix('almacenes')->name('almacenes.')->group(function () {
        Route::get('/{almacen}/inventario', [AlmacenController::class, 'inventario'])->name('inventario');
        Route::get('/{almacen}/movimientos', [AlmacenController::class, 'movimientos'])->name('movimientos');
        Route::get('/{almacen}/exportar-inventario', [AlmacenController::class, 'exportarInventario'])->name('exportar-inventario');
        Route::put('/{almacen}/toggle-status', [AlmacenController::class, 'toggleStatus'])->name('toggle-status');
    });    
    
    // Productos
    Route::resource('productos', ProductoController::class)->parameters([
        'productos' => 'producto'
    ]);
    Route::post('/productos/{producto}/ajustar-stock', [ProductoController::class, 'ajustarStock'])->name('productos.ajustar-stock');
    Route::put('/productos/{producto}/toggle-status', [ProductoController::class, 'toggleStatus'])->name('productos.toggle-status');

    // Movimientos
    Route::prefix('movimientos')->name('movimientos.')->group(function () {
        Route::get('/entrada', [MovimientoController::class, 'createEntrada'])->name('entrada');
        Route::post('/entrada', [MovimientoController::class, 'storeEntrada'])->name('entrada.store');
        
        Route::get('/salida', [MovimientoController::class, 'createSalida'])->name('salida');
        Route::post('/salida', [MovimientoController::class, 'storeSalida'])->name('salida.store');
        
        Route::get('/traslado', [MovimientoController::class, 'createTraslado'])->name('traslado');
        Route::post('/traslado', [MovimientoController::class, 'storeTraslado'])->name('traslado.store');
        
        Route::get('/historial', [MovimientoController::class, 'historial'])->name('historial');
        Route::get('/get-stock', [MovimientoController::class, 'getStock'])->name('get-stock');
    });
});