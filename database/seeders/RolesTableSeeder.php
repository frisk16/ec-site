<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['ROLE_FREE', 'ROLE_PAID'];

        foreach($names as $name) {
            Role::create([
                'name' => $name
            ]);
        }
    }
}
