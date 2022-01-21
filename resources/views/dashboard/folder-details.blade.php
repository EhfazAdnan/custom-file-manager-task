@extends('layouts.dashboard')

@section('content')

    <div class="col-md-9">
        <h3>My Files / Folders / {{$folderName->name}}</h3>   
        
        @if(session('status'))
           <div class="alert alert-success">{{session('status')}}</div>
        @endif

        <div class="row mt-5">
            @foreach ($fileFolders as $fileFolder)
            <div class="col-md-2">
                <div class="div">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder" viewBox="0 0 16 16">
                        <path d="M.54 3.87.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31zM2.19 4a1 1 0 0 0-.996 1.09l.637 7a1 1 0 0 0 .995.91h10.348a1 1 0 0 0 .995-.91l.637-7A1 1 0 0 0 13.81 4H2.19zm4.69-1.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707z"/>
                      </svg>
                    <a href="{{route('folder-details',['id'=>$fileFolder->id])}}">{{$fileFolder->name}}</a>
                </div>
            </div>
            @endforeach    
        </div>

    </div>

    <div class="col-md-1">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            + New
        </button>
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