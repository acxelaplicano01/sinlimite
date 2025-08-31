<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ProductList;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Ruta para mostrar productos por categoría usando DetallesCategoria
Route::get('/detallesCategoria/{categoria}', \App\Livewire\DetallesCategoria::class)->name('detallesCategoria');

Route::get('/detalleProducto/{id?}', \App\Livewire\DetalleProducto::class)->name('detalleProducto');

// Mantener la ruta antigua para compatibilidad
Route::get('/detalleProductoCategoria', function () {
    return redirect()->route('detalleProducto');
})->name('detalleProductoCategoria');

Route::get('/productos', ProductList::class)->name('productos');

// Ruta para productos por categoría usando ProductList
Route::get('/productos/categoria/{categoria}', ProductList::class)->name('productos.categoria');

// Rutas para carrito y favoritos (requieren autenticación)
Route::middleware('require.auth')->group(function () {
    Route::get('/carrito', \App\Livewire\Carrito::class)->name('carrito');
    Route::get('/favoritos', \App\Livewire\Favoritos::class)->name('favoritos');
    Route::get('/mis-pedidos', \App\Livewire\HistorialPedidos::class)->name('mis-pedidos');
});

// Ruta para dashboard de pedidos (requiere autenticación)
Route::middleware('auth')->group(function () {
    Route::get('/pedidos/dashboard', \App\Livewire\PedidosDashboard::class)->name('pedidos.dashboard');
    Route::get('/reportes/ventas', \App\Livewire\ReportesVentas::class)->name('reportes.ventas');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
