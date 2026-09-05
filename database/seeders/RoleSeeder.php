<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Create the application roles.
     */
    public function run(): void
    {
        Role::findOrCreate('admin', 'web');
    }
}
