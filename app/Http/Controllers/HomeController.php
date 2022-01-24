<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Get the currently authenticated user...
        $user = Auth::user();

        // Get the currently authenticated user's ID...
        $user_id = Auth::id();

        // Get folder values
        $fileFolders = File::where('userid',$user_id)->where('level',1)->paginate(6);

        // get files
        $files = File::where('userid',$user_id)->where('parent_id',$user_id)->where('type','files')->paginate(6);

        $findRoot = File::where('userid',$user_id)->where('parent_id',0)->first();

        return view('dashboard.home',compact('user_id','fileFolders','findRoot','files'));
    }

    public function recents()
    {
        return view('dashboard.recents');
    }

    public function trash()
    {
        return view('dashboard.trash');
    }

    // admin function
    public function adminIndex(){
        return view('admin.adminhome');
    }
}
