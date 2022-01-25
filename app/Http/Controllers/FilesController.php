<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
            // Get the currently authenticated user's ID...
            $user_id = Auth::id();
        
            // Get file/folder values
            $folderName = File::where('userid',$user_id)->where('id',$id)->first();
            $parent_id = $folderName->parent_id;

            $findRoot = File::where('userid',$user_id)->where('parent_id',$parent_id)->where('id',$id)->first();

            // Get folder values
            $fileFolders = File::where('userid',$user_id)->where('parent_id',$id)->where('type','folder')->paginate(6);

            // get files
            $files = File::where('userid',$user_id)->where('parent_id',$id)->where('type','files')->paginate(6);
        
            return view('dashboard.folder-details',compact('user_id','folderName','findRoot','fileFolders','files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $parent_id, $serial)
    {
        $file = new File;
        $user_id = Auth::id();
        $user_information = User::where('id',$user_id)->first();
        $root_path = $user_information->initial_storage_path;

        $find_parent_record = File::where('parent_id', $parent_id)->where('userid',$user_id)->where('serial',$serial)->first();
        if($find_parent_record){
            $fetch_id = $find_parent_record->id;
            $fetch_level = $find_parent_record->level;
            $fetch_folder_name = $find_parent_record->name;
            $fetch_folder_url = $find_parent_record->url;
            $fetch_folder_serial = $find_parent_record->serial;
        }

        if($fetch_folder_name && $fetch_level > 0){
            $root_path = $fetch_folder_url.'/'.$fetch_folder_name;
        }

        if(isset($fetch_level)){
            $fetch_level = $fetch_level + 1;
        }

        $max_serial = File::max('serial');
        $max_serial = $max_serial + 1;
        
        $file->userid = $user_id;
        $file->parent_id = $fetch_id;
        $file->name = $request->folder_name;
        $file->url  = $root_path;
        $file->type = 'folder';
        $file->visibility = 0;
        $file->level = $fetch_level;
        $file->soft_delete = 0;
        $file->serial = $max_serial;

        \Storage::disk('local')->makeDirectory('public/'.$root_path.'/'.$request->folder_name,0775,true);

        $file->save();
        return redirect()->back()->with('status','Folder Created Successfully !!');
    }


    // ------------------------------------------------------
    public function storeFiles(Request $request, $id){

        $user_id = Auth::id();

        $find_parent_record = File::where('id',$id)->first();
        if($find_parent_record){
            $fetch_folder_name = $find_parent_record->name;
            $fetch_folder_url = $find_parent_record->url;
        }

        $root_path = $fetch_folder_url.'/'.$fetch_folder_name;

       if($request->hasFile('file')){
           foreach($request->file as $file){
               $filename = $file->getClientOriginalName();
               $file->storeAs('public/'.$root_path,$filename);

               $fileModel = new File;
               $fileModel->userid = $user_id;
               $fileModel->parent_id = $id;
               $fileModel->name = $filename;
               $fileModel->url  = $root_path;
               $fileModel->type = 'files';
               $fileModel->visibility = 0;
               $fileModel->level = 0;
               $fileModel->soft_delete = 0;
               $fileModel->serial = 0;

               $fileModel->save();
           }
           return redirect()->back()->with('status','Folder Created Successfully !!');
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'folder_name_edit' => 'required',
        ]);

        $folder = File::find($id);

        $folder->name = $request->folder_name_edit;

        $folder->save();
        return redirect()->back()->with('status','Folder Updated Successfully !!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $folder = File::find($id);
        $folder->soft_delete = 1;

        $folder->save();
        return redirect()->back()->with('status','Folder Removed Successfully !!');
    }
}
