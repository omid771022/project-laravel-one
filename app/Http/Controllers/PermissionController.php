<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(){

        $permissions = Permission::query();

        if($keyword = request('search')) {
            $permissions->where('name' , 'LIKE' , "%{$keyword}%")->orWhere('label' , 'LIKE' , "%{$keyword}%" );
        }

        $permissions = $permissions->latest()->paginate(20);
 return  view('admin.permission.index', compact('permissions'));
    }



    public function store(Request $request){
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions'],
            'label' => ['required', 'string', 'max:255'],
        ]);

        Permission::create($data);

        alert()->success('مطلب مورد نظر شما با موفقیت ایجاد شد');

        return redirect(route('permission.index'));
    }
    public function create(){
        return view('admin.permission.create');

    }
}
