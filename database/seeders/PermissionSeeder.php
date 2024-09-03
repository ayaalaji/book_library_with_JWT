<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $permissions = [
            'add_book',
            'update_book',
            'delete_book',
            'borrow_book'
        ];
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }    
    }

    }

