<?php

namespace Database\Seeders;

use App\Models\User;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        //creación de roles de la página administrable
        $role = Role::create(['name' => 'Administrador']);

        //Creación de permisos
        Permission::create(['name' =>'admin.home.index'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.categoria.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.categoria.store'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.categoria.update'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.categoria.destroy'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.categoria.export-pdf'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.categoria.export-excel'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.proveedor.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.proveedor.store'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.proveedor.update'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.proveedor.destroy'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.proveedor.export-pdf'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.proveedor.export-excel'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.proveedor.consultar-ruc'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.producto.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.producto.store'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.producto.update'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.producto.destroy'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.producto.export-pdf'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.producto.export-excel'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.compra.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.compra.store'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.compra.update'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.compra.destroy'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.compra.export-pdf'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.compra.export-excel'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.detallecompra.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.detallecompra.store'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.detallecompra.update'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.detallecompra.destroy'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.detallecompra.export-pdf'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.detallecompra.export-excel'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.cliente.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.cliente.store'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.cliente.update'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.cliente.destroy'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.cliente.export-pdf'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.cliente.export-excel'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.cliente.consultar-dni'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.venta.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.venta.store'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.venta.imprimir_boleta'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.venta.get-product'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.venta.get-customer'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.venta_detalle.index'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.venta_detalle.export-pdf'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.venta_detalle.export-excel'])->syncRoles([$role]);

        Permission::create(['name' =>'admin.notifications.markAsRead'])->syncRoles([$role]);
        Permission::create(['name' =>'admin.notifications.markAllAsRead'])->syncRoles([$role]);

        //Creacion de usuarios
        User::factory()->create([
            'name' => 'Brayan Ttito Mariscal',
            'email' => 'ttitomariscalbrayan@gmail.com',
            'password' => bcrypt('123456789')
        ])->assignRole('Administrador');
    }
}
