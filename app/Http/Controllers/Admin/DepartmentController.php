<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Number;
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
            'sort' => $request->input('sort') ? $request->input('sort') : Department::query()->where('parent_id', $request->input('parent_id'))->count() + 1
        ]);
        if ($departmentNew) {
            $request->session()->put('flash', ['type' => 'success', 'message' => 'Tạo đơn vị thành công!']);
        } else {
            $request->session()->put('flash', ['type' => 'error', 'message' => 'Tạo đơn vị không thành công!']);

        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $validatedField = $request->validate([
            'name' => 'required',
            'parent_id' => 'nullable|integer|exists:departments,id',
            'sort' => 'nullable|integer'
        ], [
            'name.required' => 'Vui lòng không bỏ trống!',
            'parent_id.exists' => 'Đơn vị cha không tồn tại!',
        ]);

        $department = Department::find($id);

        if ($department) {
            $department->parent_id = $request->input('parent_id');
            $department->name = $request->input('name');

            //Change sort
            if ($request->input('sort')) {
                $changeOtherSort = Department::query()->where('parent_id', $request->input('parent_id'))
                    ->where('sort', $request->input('sort'))->first();
                if ($changeOtherSort) {
                    $changeOtherSort->sort = $department->sort;
                    $changeOtherSort->save();
                }
                $department->sort = $request->input('sort');
            }
            $department->save();
            $request->session()->put('flash', ['type' => 'success', 'message' => 'Cập nhật thành công!']);
        } else {
            $request->session()->put('flash', ['type' => 'error', 'message' => 'Cập nhật không thành công!']);
        }
        return redirect()->back();
    }
    public function destroy(Request $request, $id)
    {
        $department  = Department::find($id);
        if($department){
            $department->delete();
            $request->session()->put('flash', ['type' => 'success', 'message' => 'Đã xóa thành công!']);
        }
        else {
            $request->session()->put('flash', ['type' => 'error', 'message' => 'Thao tác xóa không thành công!']);
        }
    }
}
