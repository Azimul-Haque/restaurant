<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
        	[
        		'name' => 'user-crud',
        		'display_name' => 'User CRUD',
        		'description' => 'See only Listing Of Role'
        	],
        	[
        		'name' => 'role-crud',
        		'display_name' => 'Role CRUD',
        		'description' => 'Create New Role'
        	],
        	[
        		'name' => 'receipt-crud',
        		'display_name' => 'Receipt CRUD',
        		'description' => 'Receipt and Accounts Permission'
        	],
        	[
        		'name' => 'commodity-crud',
        		'display_name' => 'Commodity CRUD',
        		'description' => 'Commodity Crud Permission'
        	]
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }

        $role = [
          [
            'name' => 'superadmin',
            'display_name' => 'Super Admin',
            'description' => 'Super Admin'
          ],
          [
            'name' => 'manager',
            'display_name' => 'Manager',
            'description' => 'Manager'
          ]
        ];

        foreach ($role as $key => $value) {
          Role::create($value);
        }
    }
}
