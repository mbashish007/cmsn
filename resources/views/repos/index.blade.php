@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Repos</div>

                <div class="card-body">
                    
                    <ul class="list-group">
                        @foreach ($repos as $repo)
                            <li class="list-group-item">
                               <a href={{route('repos.show',$repo->slug)}}>{{$repo->name}}</a> 
                               {{-- <ul class="list-group list-group-horizontal-sm " style="height: 20px" >
                                    @foreach ($repo->tags as $tag)
                                        <li class="list-group-item">{{$tag->name}} </li>
                                    @endforeach
                              </ul> --}}
                                
                              <div class="gap-multiline-items-1">
                                @foreach ($repo->tags->take(9) as $tag)
                                <span class="badge badge-secondary px-2 py-1 bg-primary">{{$tag->name}} </span>
                                @endforeach
                                
                                
                              </div>
                            </li>
                        @endforeach
                    </ul>
                    
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <a href="{{route('repos.create')}}" class="btn btn-info my-2">Create Repos</a>
            </div>
        </div>
    </div>
</div>
@endsection

