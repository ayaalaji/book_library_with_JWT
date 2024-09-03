<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin', 
            'email' => 'admin@gmail.com',
            'password' =>Hash::make('12345678'),
            'role'=> 'admin',
        ]);
        $user2 = User::create([
            'name' => 'Member', 
            'email' => 'member@gmail.com',
            'password' =>Hash::make('11111111'),
            'role'=> 'member',
        ]);
        $role = Role::create(['name' => 'Admin']);
        $roleMember =Role::create(['name' => 'Member']);

        $permissions = Permission::whereBetween('id', [1, 3])->pluck('id')->all();
        $permissionsMember = Permission::where('id',4)->pluck('id')->all();

        $role->syncPermissions($permissions);
        $roleMember->syncPermissions($permissionsMember);

        $user->assignRole($role->id);
        $user2->assignRole($roleMember->id);
    }
}
