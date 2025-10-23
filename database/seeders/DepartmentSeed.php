<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeed extends Seeder
{
    public function run(): void
    {
        $du = Department::create([
            'name' => 'Đảng ủy',
            'parent_id' => 0,
            'level' => 1
        ]);

        Department::create([
            'name' => 'Trung tâm chính trị',
            'parent_id' => $du->id,
            'level' => 2
        ]);
        Department::create([
            'name' => 'Ban xây dựng đảng',
            'parent_id' => $du->id,
            'level' => 2
        ]);

        $hdnd = Department::create([
            'name' => 'Hội đồng nhân dân',
            'parent_id' => 0,
            'level' => 1
        ]);
        Department::create([
            'name' => 'Ban kinh tế xã hội',
            'parent_id' => $hdnd->id,
            'level' => 2
        ]);
    }
}
