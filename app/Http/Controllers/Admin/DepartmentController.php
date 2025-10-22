<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function index()
    {
        $department = Department::all();
        return Inertia::render('Department/DepartmentIndex', ['department' => $department]);
    }
}
