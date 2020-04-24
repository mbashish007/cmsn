@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><span class="h4 text-primary">{{$repo->name}}</span> 
                    <a href="{{route('repos.edit',$repo->slug)}} " class="btn btn-dark btn-sm float-right">Update Repostitry</a>
                    <div class="gap-multiline-items-1 mt-2">
                        @foreach ($repo->tags->take(9) as $tag)
                        <span class="badge badge-secondary px-2 py-1 bg-primary">{{$tag->name}} </span>
                        @endforeach
                    </div>
                </div>

                <div class="card-body">
                    <h2>Files</h2>
                    <ul class="list-group">
                        @foreach ($repo->files as $file)
                            <li class="list-group-item"> <a href="{{ asset('storage/'.$file->file) }}">{{$file->name}} </a>
                                <form action="{{route('files.destroy',$file->id)}} " method="post" class="float-right">
                                @csrf
                                @method('DELETE')
                                <button type="submit"> Delete
                                </button>
                                </form>

                                <div class="d-flex justify-content-between float-right mx-1">
                                    <div>
                                        <button class="btn btn-secondary float-right btn-sm mx-1 " onclick="showRename({{$file->id}})">Rename</button>
                                    </div>
                                    <div id="rename{{$file->id}}" style="display: none">
                                        <form action="{{route('files.update',$file->id)}}" method="POST"  > 
                                            @csrf
                                            @method('PUT')
                                            <input type="text" id="name" name="name" placeholder="New File Name" >
                                            <button type="submit">Change</button>
                                        </form>
                                    </div>
                                </div>
                                
                            </li>
                        @endforeach
                    </ul>

                    @if (auth()->user()->id === $repo->user->id)
                        
                        {{-- <a href="" class="btn btn-primary">Add File</a> --}}
                        <div class="row">
                            <div class="col-2">
                                <button class="btn btn-primary" onclick="myFunction()">Add File</button>
                            </div>
                            <div class="col-10" id="form-div" style="display: none">
                                <form action="{{route('files.store')}} " method="post" id="form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="col-auto">
                                            <input type="file" class="form-control-file" name="file" id="file">
                                            <input type="hidden" name="repo" value={{$repo->id}}>
                                        </div>
                                        <button class="btn btn-light" type="submit">Add</button>
                                    </div>
                                </form>
                            </div>
                        </div>


                        
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        function myFunction() {
            var x = document.getElementById("form-div");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        } 
        function showRename($i) {
            var x = document.getElementById("rename"+$i);
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        } 
    </script>
@endsection