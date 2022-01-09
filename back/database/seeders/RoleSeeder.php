<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name'=>'Admin']);
        $role2 = Role::create(['name'=>'Coordinador']);

            Permission::create(['name' => 'permiso.index'])->syncRoles([$role1,$role2]);
            Permission::create(['name' => 'permiso.create'])->syncRoles([$role1,$role2]);
            Permission::create(['name' => 'permiso.update'])->syncRoles([$role1,$role2]);
            Permission::create(['name' => 'permiso.destroy'])->syncRoles([$role1,$role2]);


            Permission::create(['name' => 'user.index'])->syncRoles([$role1]);
            Permission::create(['name' => 'user.create'])->syncRoles([$role1]);
            Permission::create(['name' => 'user.update'])->syncRoles([$role1]);
            Permission::create(['name' => 'user.destroy'])->syncRoles([$role1]);


            Permission::create(['name' => 'empleado.index'])->syncRoles([$role1]);
            Permission::create(['name' => 'empleado.create'])->syncRoles([$role1]);
            Permission::create(['name' => 'empleado.update'])->syncRoles([$role1]);
            Permission::create(['name' => 'empleado.destroy'])->syncRoles([$role1]);


            Permission::create(['name' => 'permiso.index'])->syncRoles([$role1]);
            Permission::create(['name' => 'permiso.create'])->syncRoles([$role1]);
            Permission::create(['name' => 'permiso.update'])->syncRoles([$role1]);
            Permission::create(['name' => 'permiso.destroy'])->syncRoles([$role1]);


    }
}
