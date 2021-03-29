<?php
namespace App\Http\Controllers\Admin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //show all user
    public  function ShowUser(){
        $Users=User::query();
        if($keyword= request('search')){

            $Users->where('email' , 'LIKE' , "%{$keyword}%")->orWhere('name' , 'LIKE' , "%{$keyword}%" )->orWhere('id' , $keyword);

        }


        if(request('admin')){
            $Users->where('is_superuser',1)->orWhere('is_staff',1);
        }
        $Users=$Users->latest()->paginate(20);
       return  view('admin.users.all', compact('Users'));
    }


    public function create(){
        return view('admin.users.create');

    }

    public function store(Request $request){
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create($data);

        if($request->has('verify')) {
            $user->markEmailAsVerified();
        }

        return redirect(route('indexpanel'));
    }

    public function edit(Request $request ,$id)
    {
    
           $userid=User::where('id', $id)->first();

                 // if(Gate::allows('edit-user', $userid)){
                // return view('admin.users.edit' , compact('userid'));
               //   }
    
      //  abort(403);

//  if(Gate::denies('edit-user', $userid)){
//     abort(403);
//  }

$this->authorize('edit-user', $userid);
 return view('admin.users.edit' , compact('userid'));
    }
    public function update(UpdateRequest $request, $id)
    {
        // $data = $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255'],
        // ]);

        // if(! is_null($request->password)) {
        //     $request->validate([
        //         'password' => ['required', 'string', 'min:8', 'confirmed'],
        //     ]);

        //     $data['password'] = $request->password;
        // }

        // $userid->update($data);

        // if($request->has('verify')) {
        //     $userid->markEmailAsVerified();
        // }


        User::where('id',$id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        return redirect(route('indexpanel'));
    }



    public function  delete(Request $request, $id){

       
        User::where('id',$id)->delete();
        alert()->success('مطلب مورد نظر شما با موفقیت ویرایش شد');
        return back();
    }
}
