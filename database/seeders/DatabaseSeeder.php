<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // create permissions
        Permission::create(['name' => 'Lista peliculas']);
        Permission::create(['name' => 'Informacion de la pelicula']);
        Permission::create(['name' => 'Busqueda de peliculas']);
        Permission::create(['name' => 'Filtra peliculas por genero']);
        Permission::create(['name' => 'Eliminar pelicula']);
        Permission::create(['name' => 'Editar pelicula']);
        Permission::create(['name' => 'Crear pelicula']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $admin = Role::create(['name' => 'Admin']);
        $admin->givePermissionTo(Permission::all());


        // or may be done by chaining
        $customer = Role::create(['name' => 'customer']);
        $customer->givePermissionTo(['Lista peliculas', 'Informacion de la pelicula', 'Busqueda de peliculas', 'Filtra peliculas por genero']);


    }
}
