@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div id="name-like">
                        <span class="h4 text-primary">{{$repo->name}}</span> 
                        <div class="like-btn ml-2">
                              
                            <i id="like{{$repo->id}}" data-id="{{ $repo->id }} " class="fa fa-thumbs-up {{(auth()->user()->hasLiked($repo)) ? 'liked' : ''}} "></i> 
                            <div id="like{{$repo->id}}-bs3" class="" style="display: inline">{{ $repo->likers()->count() }}</div>
                            {{-- <i onclick="myFunction(this)" class="fa fa-thumbs-up"></i> --}}
    
                                {{-- <script>
                                function myFunction(x) {
                                x.classList.toggle("fa-thumbs-down");
                                }
                            </script> --}}
                        </div>
                    </div>
                    <a href="{{route('repos.edit',$repo->slug)}} " id="update-btn"   class="btn btn-dark btn-sm float-right">Update Repostitry</a>
                    <div class="gap-multiline-items-1 mt-1">
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

@section('css')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>

    .like-btn {
        margin-top: -2px;
    }

    .fa {
        color: #444;
        height: 26px;
        width: 24;
    }

    .liked {
        color: blue;
    }

    

    #repo-name {
        display: flex;
        flex-direction: row;
    }

    .repo-lead {
        font-size: 18px;
    }

    #name-like {
        display: flex;
        flex-direction: row;
    }

    #update-btn {
        position: absolute;
        top: 12px;
        right: 15px;
    }


</style>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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

        $(document).ready(function() {     
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $('i.fa-thumbs-up').click(function(){    
                var id = $(this).data('id');
                var c = $('#'+this.id+'-bs3').html();
                var cObjId = this.id;
                var cObj = $(this);
    
                $.ajax({
                   type:'POST',
                   url:'/repos/like',
                   data:{id:id},
                   success:function(data,status){
                    //   if(jQuery.isEmptyObject(data.success.attached)){
                    //     $('#'+cObjId+'-bs3').html(parseInt(c)-1);
                    //     $(cObj).removeClass("like-post");
                    //   }else{
                    //     $('#'+cObjId+'-bs3').html(parseInt(c)+1);
                    //     $(cObj).addClass("like-post");
                    //   }
                        if(data.liked){
                            $(cObj).addClass('liked');
                            $('#'+cObjId+'-bs3').html(parseInt(c)+1);
                        }
                        else {
                            $(cObj).removeClass('liked');
                            $('#'+cObjId+'-bs3').html(parseInt(c)-1);
                        }
                    // var obj = JSON.parse('{ "name":"John", "age":30, "city":"New York"}');
                    // // var obj = JSON.parse(data);
                    // var obj = data.name; 
                    // alert("Data: " + obj + "\nStatus: " + status);
                   }////
                });


                // $.post("{{route('likeRepo')}}",
                //     {
                //         // "csrf-token": "{{ csrf_token() }}",
                //         name: "Donald Duck",
                //         city: "Duckburg"
                //     },
                //     function(data, status){
                //         alert("Data: " + data + "\nStatus: " + status);
                //     });

                
    
            });      
    
            $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox();
            });                                        
        }); 
    </script>
@endsection