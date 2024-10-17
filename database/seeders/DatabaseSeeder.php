<?php

namespace Database\Seeders;

use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Branch;
use App\Models\GtList;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use App\Permissions\Permissions;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        $permissions = new Permissions();

        $branch = Branch::create([
            'country' => 'Egypt',
            'city' => 'Giza',
            'district' => 'Dokki'
        ]);

        Branch::create([
            'country' => 'Egypt',
            'city' => 'Cairo',
            'district' => 'Nasr City'
        ]);

        GtList::create([
            'list_title' => 'Wait List'
        ]);

        GtList::create([
            'list_title' => 'Pending List'
        ]);

        GtList::create([
            'list_title' => 'Hold List'
        ]);

        GtList::create([
            'list_title' => 'Refund List'
        ]);

        GtList::create([
            'list_title' => 'Blacklist'
        ]);

        $role = Role::create([
            'role' => 'Trainer'
        ]);
        
        foreach($permissions->permission as $collection_key => $per_collection)
        {
            foreach($per_collection as $per_key => $per_value)
            {
                is_string($per_key) ? $key = $per_key :  $key = $per_value; 
                
                Permission::create([
                    'role_id' => $role->id,
                    'per_collection' => $collection_key,
                    'per_key' => $key,
                    'per_value' => true
                ]);
            }
        }
        
        User::create([
            'branch_id' => $branch->id,
            'role_id' => $role->id,
            'full_name' => 'Mohamed',
            'email' => 'admin@admin.cc',
            'password' => Hash::make('admin123'),
            'is_activated' => true,
        ]);
    }
}