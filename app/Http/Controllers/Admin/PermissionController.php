<?php

namespace App\Http\Controllers\Admin;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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


      /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit' , compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255' ],
            'label' => ['required', 'string',  'max:255'],
        ]);

        $permission->update($data);

        alert()->success('مطلب مورد نظر شما با موفقیت ویرایش شد');
        return redirect(route('admin.permissions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission, $id)
    {
        Permission::where('id',$id)->delete();
        alert()->success('مطلب مورد نظر شما با موفقیت ویرایش شد');
        return back();
    }
}
