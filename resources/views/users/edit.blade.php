@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Profile</div>

                <div class="card-body">
                    <form action="{{route('users.update',$user->id)}} " method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                                <img src="{{asset($user->profile_pic())}} " width="100px" alt="profile">
                            <input type="file" class="form-control-file" name="profilepic" id="profilepic">
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" value="{{$user->name}}">
                        </div>
                        <button type="submit" class="btn btn-outline-dark">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
