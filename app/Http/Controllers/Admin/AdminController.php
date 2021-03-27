<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function  index(){
        return  view('admin.master');
    }


    public function indexpanel(){
        return view('admin.index');
    }

}



