@extends('layouts.dashboard')

@section('content')

    <div class="col-md-8">
        <h3><a href="{{route('dashboard.home')}}">Root</a> / {{$folderName->name}}</h3>   
        
        @if(session('status'))
           <div class="alert alert-success">{{session('status')}}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row mt-3 mb-5">
            @foreach ($fileFolders as $fileFolder)
                <div class="card mb-2" style="width: 18rem;">

                    <div class="row">
                        <div class="col-md-1">
                            <button type="button" class="btn btn-default" data-bs-toggle="modal" data-bs-target="#editDeleteModal{{$fileFolder->id}}">
                                <p style="font-weight: bold;">&bull;&bull;&bull;&bull;</p>
                            </button>
                        </div>

                        <div class="col-md-1 offset-md-9">
                            <form onsubmit="return confirm('Do you really want delete?');" action="{{route('folder.delete',['id'=>$fileFolder->id])}}" method="POST">
                                {{ method_field('delete') }}
                                @csrf
                                <button type="submit" class="btn btn-default"><p style="font-weight: bold;color:red;">X<p></button>
                            </form>
                        </div>

                        <!-- Modal edit delete -->
                        <div class="modal fade" id="editDeleteModal{{$fileFolder->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editDeleteModal{{$fileFolder->id}}Label" aria-hidden="true">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="editDeleteModal{{$fileFolder->id}}Label">Edit Folder Name</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="{{route('folder.update',['id'=>$fileFolder->id])}}" method="POST">
                                @csrf
                                <div class="modal-body">

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floatingInput" placeholder="Edit folder" name="folder_name_edit" value="{{$fileFolder->name}}">
                                        <label for="floatingInput">Edit folder name ..</label>
                                    </div>

                                    <select class="form-select" aria-label="Default select private" name="visibity">
                                        <option selected value="0">Private</option>
                                        <option value="1">Public</option>
                                    </select>
                                    
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                                </form>

                            </div>
                            </div>
                        </div>

                    </div>

                    <a style="text-decoration: none;" href="{{route('folder-details',['id'=>$fileFolder->id])}}">
                    <svg class="mt-2" xmlns="http://www.w3.org/2000/svg" width="260" height="100" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16">
                        <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/>
                    </svg>
                    </a>

                    <div class="card-body">
                    <h5 class="card-title text-center"><a style="text-decoration: none;" href="{{route('folder-details',['id'=>$fileFolder->id])}}">{{$fileFolder->name}}</a></h5>
                    </div>
                </div>
          @endforeach    
          <div class="text-center">{{$fileFolders->links()}}</div>
        </div>

        <div class="row mt-3">
            <h3>My Files</h3>
            @foreach ($files as $file)

            @if (strpos($file, 'pdf') !== false)
            <div class="col-md-4">
                <div class="card mb-2">

                    <div class="row">

                        <div class="col-md-1">
                            <button type="button" class="btn btn-default">
                                <p style="font-weight: bold;color:green;"><a href="{{route('download')}}">&#8595;</a></p>
                            </button>
                        </div>

                        <div class="col-md-1 offset-md-9">
                            <form onsubmit="return confirm('Do you really want delete?');" action="{{route('file.delete',['id'=>$file->id])}}" method="POST">
                                {{ method_field('delete') }}
                                @csrf
                                <button type="submit" class="btn btn-default"><p style="font-weight: bold;color:red;">X<p></button>
                            </form>
                        </div>

                    </div>

                   <embed src="{{ asset('storage/'.$file->url.'/'.$file->name) }}" />
                    <div class="card-body">
                      <h5>{{\Illuminate\Support\Str::limit($file->name,20)}}</h5>
                    </div>
                </div>
            </div>
            @else
            <div class="col-md-3">
                <div class="card mb-2">

                    <div class="row">

                        <div class="col-md-1">
                            <button type="button" class="btn btn-default">
                                <p style="font-weight: bold;color:green;"><a href="{{route('download',['id'=>$file->id])}}">&#8595;</a></p>
                            </button>
                        </div>

                        <div class="col-md-1 offset-md-7">
                            <form onsubmit="return confirm('Do you really want delete?');" action="{{route('file.delete',['id'=>$file->id])}}" method="POST">
                                {{ method_field('delete') }}
                                @csrf
                                <button type="submit" class="btn btn-default"><p style="font-weight: bold;color:red;">X<p></button>
                            </form>
                        </div>
                    </div>

                    <img src="{{ asset('storage/'.$file->url.'/'.$file->name) }}" class="img-thumbnail" alt="{{$file->name}}">
                    <div class="card-body">
                      <h5>{{\Illuminate\Support\Str::limit($file->name,20)}}</h5>
                    </div>
                </div>
            </div>
            @endif
            
            @endforeach    
        </div>

    </div>

    <div class="col-md-2">

        <div class="card">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            + New
        </button>
        </div>

        <form action="{{route('files.create',['id'=>$findRoot->id])}}" method="post" enctype="multipart/form-data" class="mt-5">
            @csrf
            <input type="file" name="file[]" multiple="true" class="form-control">
            <div class="card mt-1">
               <button class="btn btn-sm btn-primary" type="submit">Upload</button>
            </div>
        </form>

    </div>

      <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Create New Folder User ID ({{$user_id}}) - Level ({{$findRoot->level}}) - id ({{$findRoot->id}})</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{route('folder.create',['parent_id'=>$findRoot->parent_id,'serial'=>$findRoot->serial])}}" method="POST">
                   @csrf
                   <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="new folder" name="folder_name">
                        <label for="floatingInput">New folder name ..</label>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
                </div>
                </form>

            </div>
            </div>
        </div>

@endsection
