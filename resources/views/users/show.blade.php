@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$user->name}}
                    <a href="{{route('users.edit',$user->id)}} " class="btn btn-outline-dark float-right bg-secondary text-white">Update Profile</a>
                </div>

                <div class="card-body">
                   <img src="{{ asset($user->profile_pic()) }}"  width="240px" alt="profile pic">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection