<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdministratorPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            'title' => 'administrator',
            'permissions' => 'dashboard,permissionsAndEmployees.permission.index,permissionsAndEmployees.permission.create',
            'created_at' => now(),
            'created_by' => 1,
        ]);
    }
}
