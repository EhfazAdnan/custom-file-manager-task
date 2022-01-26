<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    // admin function
    public function index(){

        $users = User::all();
        return view('admin.adminhome',compact('users'));
    }

    public function update(Request $request, $id)
    {

        $this->validate($request,[
            'file_extensions' => 'required',
            'storage_size' => 'required',
        ]);

        $user = User::find($id);

        $user->file_extensions = $request->file_extensions;
        $user->storage_size = $request->storage_size;

        $user->save();
        return redirect()->back()->with('status','Status Updated Successfully !!');

    }
}
