<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();

        return Inertia::render('Department/DepartmentIndex', ['departments' => $departments]);
    }

    public function store(Request $request)
    {
        $validatedField = $request->validate([
            'name' => 'required',
            'parent_id' => 'nullable|integer|exists:departments,id',
            'sort' => 'nullable|integer'
        ], [
            'name.required' => 'Vui lòng không bỏ trống!',
            'parent_id.exists' => 'Đơn vị cha không tồn tại!',
        ]);

        $departmentNew = Department::create([
            'parent_id' => $request->input('parent_id'),
            'name' => $request->input('name'),
            'sort' => $request->input('sort')
        ]);
        if ($departmentNew) {
            $request->session()->put('flash', ['type' => 'success', 'message' => 'Tạo đơn vị thành công!']);
        } else {
            $request->session()->put('flash', ['type' => 'error', 'message' => 'Tạo đơn vị không thành công!']);

        }
        return redirect()->back();
    }
}
