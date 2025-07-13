<?php

use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ClienteController;
use App\Http\Controllers\Admin\CompraController;
use App\Http\Controllers\Admin\ProductoController;
use App\Http\Controllers\Admin\ProveedorController;
use App\Http\Controllers\Admin\DetalleCompraController;
use App\Http\Controllers\Admin\Venta_detalleController;
use App\Http\Controllers\Admin\VentaController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::prefix('admin')->group(function () {
    Route::resource('categoria', CategoriaController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.categoria')->middleware('can:admin.categoria.index');
    Route::get('categoria/export-pdf', [CategoriaController::class, 'exportPdf'])->name('admin.categoria.export-pdf')->middleware('can:admin.categoria.index');
    Route::get('categoria/export-excel', [CategoriaController::class, 'exportExcel'])->name('admin.categoria.export-excel')->middleware('can:admin.categoria.export-excel');

    Route::resource('proveedor', ProveedorController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.proveedor')->middleware('can:admin.proveedor.index');
    Route::get('proveedor/export-pdf', [ProveedorController::class, 'exportPdf'])->name('admin.proveedor.export-pdf')->middleware('can:admin.proveedor.index');
    Route::get('proveedor/export-excel', [ProveedorController::class, 'exportExcel'])->name('admin.proveedor.export-excel')->middleware('can:admin.proveedor.index');

    Route::resource('producto', ProductoController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.producto')->middleware('can:admin.producto.index');
    Route::get('producto/export-pdf', [ProductoController::class, 'exportPdf'])->name('admin.producto.export-pdf')->middleware('can:admin.producto.index');
    Route::get('producto/export-excel', [ProductoController::class, 'exportExcel'])->name('admin.producto.export-excel')->middleware('can:admin.producto.index');

    Route::resource('compra', CompraController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.compra')->middleware('can:admin.compra.index');
    Route::get('compra/export-pdf', [CompraController::class, 'exportPdf'])->name('admin.compra.export-pdf')->middleware('can:admin.compra.index');
    Route::get('compra/export-excel', [CompraController::class, 'exportExcel'])->name('admin.compra.export-excel')->middleware('can:admin.compra.index');

    Route::resource('detallecompra', DetalleCompraController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.detallecompra')->middleware('can:admin.detallecompra.index');
    Route::get('detallecompra/export-pdf', [DetalleCompraController::class, 'exportPdf'])->name('admin.detallecompra.export-pdf')->middleware('can:admin.detallecompra.index');
    Route::get('detallecompra/export-excel', [DetalleCompraController::class, 'exportExcel'])->name('admin.detallecompra.export-excel')->middleware('can:admin.detallecompra.index');

    Route::resource('cliente', ClienteController::class)->only(['index', 'store', 'update', 'destroy'])->names('admin.cliente')->middleware('can:admin.cliente.index');
    Route::get('cliente/export-pdf', [ClienteController::class, 'exportPdf'])->name('admin.cliente.export-pdf')->middleware('can:admin.cliente.index');
    Route::get('cliente/export-excel', [ClienteController::class, 'exportExcel'])->name('admin.cliente.export-excel')->middleware('can:admin.cliente.index');

    Route::resource('venta', VentaController::class)->only(['index', 'store'])->names('admin.venta')->middleware('can:admin.venta.index');
    Route::get('venta/export-pdf', [VentaController::class, 'exportPdf'])->name('admin.venta.export-pdf')->middleware('can:admin.venta.index');
    Route::get('venta/export-excel', [VentaController::class, 'exportExcel'])->name('admin.venta.export-excel')->middleware('can:admin.venta.index');

    Route::resource('venta_detalle', Venta_detalleController::class)->only(['index'])->names('admin.venta_detalle')->middleware('can:admin.venta_detalle.index');
    

    Route::get('venta_detalle/export-pdf', [Venta_detalleController::class, 'exportPdf'])
        ->name('admin.venta_detalle.export-pdf')
        ->middleware('can:admin.venta_detalle.export-pdf');
    Route::get('venta/{sale}/imprimir-boleta', [Venta_detalleController::class, 'generateBoletaPrint'])
        ->name('admin.venta.imprimir_boleta')
        ->middleware('can:admin.venta.imprimir_boleta');
   // Ruta para consultar DNI
    Route::get('cliente/consultar-dni', [ClienteController::class, 'consultarDni'])->name('admin.cliente.consultar-dni')->middleware('can:admin.cliente.consultar-dni');
    // Ruta para consultar RUC
    Route::get('/proveedor/consultar-ruc', [ProveedorController::class, 'consultarRuc'])->name('admin.proveedor.consultar-ruc')->middleware('can:admin.proveedor.consultar-ruc');
    // Ruta para consultar producto por código
    Route::post('/venta/get-product', [VentaController::class, 'getProduct'])->name('admin.venta.get-product')->middleware('can:admin.venta.get-product');
    // Ruta para consultar cliente por DNI
    Route::post('/venta/get-customer', [VentaController::class, 'getCustomer'])->name('admin.venta.get-customer')->middleware('can:admin.venta.get-customer');

    // Rutas para notificaciones
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.markAsRead')->middleware('can:admin.notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.markAllAsRead')->middleware('can:admin.notifications.markAllAsRead');
});


require __DIR__.'/auth.php';
