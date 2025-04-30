<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           // Crear roles
           $super_admin = Role::firstOrCreate(['name' => 'super_admin']);
           $admin = Role::firstOrCreate(['name' => 'admin']);
        
   
           // Crear permisos
           Permission::create(['name' => 'crear_productos']);
           Permission::create(['name' => 'ver_productos']);
           Permission::create(['name' => 'editar_productos']);
           Permission::create(['name' => 'elimnar_productos']);
         

           Permission::create(['name' => 'crear_categorias']);
           Permission::create(['name' => 'ver_categorias']);
           Permission::create(['name' => 'editar_categorias']);
           Permission::create(['name' => 'elimnar_categorias']);

           Permission::create(['name' => 'crear_proveedor']);
           Permission::create(['name' => 'ver_proveedor']);
           Permission::create(['name' => 'editar_proveedor']);
           Permission::create(['name' => 'elimnar_proveedor']);
           
           Permission::create(['name' => 'crear_cliente']);
           Permission::create(['name' => 'ver_cliente']);
           Permission::create(['name' => 'editar_cliente']);
           Permission::create(['name' => 'elimnar_cliente']);


           Permission::create(['name' => 'crear_ingreso']);
           Permission::create(['name' => 'ver_ingreso']);
           Permission::create(['name' => 'editar_ingreso']);
           Permission::create(['name' => 'elimnar_ingreso']);
   
           Permission::create(['name' => 'crear_salida']);
           Permission::create(['name' => 'ver_salida']);
           Permission::create(['name' => 'editar_salida']);
           Permission::create(['name' => 'elimnar_salida']);

           Permission::create(['name' => 'crear_movimento']);
           Permission::create(['name' => 'ver_movimento']);
           Permission::create(['name' => 'editar_movimento']);
           Permission::create(['name' => 'elimnar_movimento']);



           // Asignar permisos a roles
         


          $super_admin->givePermissionTo('crear_productos');
          $super_admin->givePermissionTo('ver_productos');
          $super_admin->givePermissionTo('editar_productos');
          $super_admin->givePermissionTo('elimnar_productos');
          $super_admin->givePermissionTo('crear_categorias');

          $super_admin->givePermissionTo('crear_categorias');
          $super_admin->givePermissionTo('ver_categorias');
          $super_admin->givePermissionTo('editar_categorias');
          $super_admin->givePermissionTo('elimnar_categorias');

          $super_admin->givePermissionTo('crear_proveedor');
          $super_admin->givePermissionTo('ver_proveedor');
          $super_admin->givePermissionTo('editar_proveedor');
          $super_admin->givePermissionTo('elimnar_proveedor');
           
          $super_admin->givePermissionTo('crear_cliente');
          $super_admin->givePermissionTo('ver_cliente');
          $super_admin->givePermissionTo('editar_cliente');
          $super_admin->givePermissionTo('elimnar_cliente');



          $super_admin->givePermissionTo('crear_ingreso');
          $super_admin->givePermissionTo('ver_ingreso');
          $super_admin->givePermissionTo('editar_ingreso');
          $super_admin->givePermissionTo('elimnar_ingreso');
   
          $super_admin->givePermissionTo('crear_salida');
          $super_admin->givePermissionTo('ver_salida');
          $super_admin->givePermissionTo('editar_salida');
          $super_admin->givePermissionTo('elimnar_salida');

          $super_admin->givePermissionTo('crear_movimento');
          $super_admin->givePermissionTo('ver_movimento');
          $super_admin->givePermissionTo('editar_movimento');
          $super_admin->givePermissionTo('elimnar_movimento');
         
          $admin->givePermissionTo('ver_productos');
          $admin->givePermissionTo('ver_categorias');
          $admin->givePermissionTo('ver_proveedor');
          $admin->givePermissionTo('ver_cliente');
          $admin->givePermissionTo('ver_ingreso');
          $admin->givePermissionTo('ver_salida');
          $admin->givePermissionTo('ver_movimento');

        }
}
