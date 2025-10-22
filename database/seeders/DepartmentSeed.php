<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\DepartmentGroup;
use Illuminate\Database\Seeder;

class DepartmentSeed extends Seeder
{
    public function run(): void
    {
        DepartmentGroup::factory()->count(10);
    }
}
