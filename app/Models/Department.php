<?php

namespace App\Models;

use App\Http\Controllers\Admin\DepartmentController;
use App\TreeService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id', 'level', 'created_at', 'updated_at'];
}
