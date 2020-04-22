@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tags</div>

                <div class="card-body">
                    
                    <ul class="list-group">
                        @foreach ($tags as $tag)
                            <li class="list-group-item">
                                <div class="border border-primary p-2 mr-1 rounded-pill" style="display:inline">Repos <span class="badge badge-pill badge-info">{{$tag->repos()->count()}}</span></div>
                               {{$tag->name}} 

                               <form action="{{route('tags.destroy',$tag->id)}} " method="post" class="float-right">
                                @csrf
                                @method('DELETE')
                                <button type="submit"> Delete
                                </button>
                                </form>
                               
                               <div class="d-flex justify-content-between float-right mx-1">
                                    <div>
                                        <button class="btn btn-secondary float-right btn-sm mx-1 " onclick="showRename({{$tag->id}})">Rename</button>
                                    </div>
                                    <div id="rename{{$tag->id}}" style="display: none">
                                        <form action="{{route('tags.update',$tag->id)}}" method="POST"  > 
                                            @csrf
                                            @method('PUT')
                                            <input type="text" id="name" name="name" placeholder="New Tag Name" >
                                            <button type="submit">Change</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    
                </div>
            </div>
                {{$tags->links()}}
            <div class="d-flex justify-content-center mt-4">
                <form action="{{route('tags.store')}} " class="form-inline" method="post">
                    @csrf
                    {{-- <label class="form-label" for="name">Create Tag</label> --}}
                    <input type="text" class="form-control mb-2 mr-sm-2 @error('name') is-invalid @enderror" id="name" name="name" placeholder="Tag Name" value="{{old('name')}}">
                    
                    <div>
                        @error('name')
                        {{-- <div style="height: 44px" class="alert alert-danger form-label">{{ $message }}</div> --}}
                        <label for="name" class="form-label bg-danger mx-2 text-white mb-2 p-1 px-2">{{ $message }}</p>
                    @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Create</button>
                </form>
                {{-- <a href="{{route('repos.create')}}" class="btn btn-info my-2">Create Repos</a> --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        // function myFunction() {
        //     var x = document.getElementById("form-div");
        //     if (x.style.display === "none") {
        //         x.style.display = "block";
        //     } else {
        //         x.style.display = "none";
        //     }
        // } 
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