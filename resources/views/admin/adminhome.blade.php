@extends('layouts.admin')

@section('admin_content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Admin Dashboard') }}</div>

                @if(session('status'))
                <div class="alert alert-success">{{session('status')}}</div>
                @endif

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Base URL</th>
                            <th scope="col">Role</th>
                            <th scope="col">File Extensions</th>
                            <th scope="col">Storage Limit</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>

                          @foreach ($users as $user)
                            <tr>
                              <form action="{{route('user.update',['id'=>$user->id])}}" method="POST">
                                @csrf
                                  <th scope="row">{{$user->id}}</th>
                                  <td>{{$user->name}}</td>
                                  <td>{{$user->email}}</td>
                                  <td>{{$user->initial_storage_path}}</td>
                                  <td>{{$user->is_admin}}</td>
                                  <td><input type="text" name="file_extensions" value="{{$user->file_extensions}}"></td>
                                  <td><input type="number" name="storage_size" value="{{$user->storage_size }}"></td>
                                  <td><button type="submit" class="btn btn-primary">Update</button></td>
                              </form>
                            </tr>
                          @endforeach
                          
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
