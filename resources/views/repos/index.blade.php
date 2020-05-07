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
                                <div class="float-right">
                                    <span class="text-success">{{$repo->user->username}} </span>
                                    <a href="{{route('users.show',$repo->user->id)}} "><img src="{{ asset($repo->user->profile_pic()) }}" alt="Avatar" class="avatar"></a>
                                    {{-- @if ($repo->user->image)
                                    <a href="{{route('users.show',$repo->user->id)}} "><img src="{{ asset('storage/'.$repo->user->image->image) }}" alt="Avatar" class="avatar"></a>
                                    @else
                                    <a href="{{route('users.show',$repo->user->id)}}"><img src="{{ asset('storage/images/blank-profile-picture-973460_640.png') }}" alt="Avatar" class="avatar"></a>
                                    @endif --}}
                                </div>
                                <div id="repo-name">
                                    
                                    <a href={{route('repos.show',$repo->slug)}}><span class="repo-lead">{{$repo->name}}</span></a> 
                                    <div class="like-btn ml-2">
                                        {{-- <i id="like{{$repo->id}}" data-id="{{ $repo->id }} " class="fa fa-thumbs-up {{(auth()->user()->hasLiked($repo)) ? 'liked' : ''}} "></i>  --}}
                                        <a href="javascript:void(0);" id="like{{$repo->id}}" data-id="{{ $repo->id }} " class="fa fa-thumbs-up {{(auth()->user()->hasLiked($repo)) ? 'liked' : ''}}"></a>
                                        <div id="like{{$repo->id}}-bs3" class="cnt" style="display: inline">{{ $repo->likers()->count() }}</div>
                                        {{-- <i onclick="myFunction(this)" class="fa fa-thumbs-up"></i> --}}

                                            {{-- <script>
                                            function myFunction(x) {
                                            x.classList.toggle("fa-thumbs-down");
                                            }
                                        </script> --}}
                                    </div>
                                    

                                </div>
                                
                                
                               {{-- <ul class="list-group list-group-horizontal-sm " style="height: 20px" >
                                    @foreach ($repo->tags as $tag)
                                        <li class="list-group-item">{{$tag->name}} </li>
                                    @endforeach
                              </ul> --}}
                                
                              <div class="gap-multiline-items-1 mt-2">
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

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    a {
        text-decoration: none;
    }

    
.like-btn {
        margin-top: 1px;
    }

    /* .fa {
        color: #444;
    } */

    
    .cnt {
        margin-top: -1.5px;
    }
        

    #repo-name {
        display: flex;
        flex-direction: row;
    }

    .repo-lead {
        font-size: 18px;
    }

    .fa {
        padding: 5px 5px;
        font-size:18px;
        width: 30px;
        text-align: center;
        text-decoration: none;
        /* margin: 5px 2px; */
        background: #777;
        color:white;
        border-radius: 50%;
    }

    .fa:hover {
        text-decoration: none;
        background: #eee;
    }

    .liked {
        color: blue;
        background: #eee;
        text-decoration: none;
    }

    .liked:hover {
        color: red;
    }

    .avatar {
        vertical-align: middle;
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }


</style>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
    {{-- <script src="https://kit.fontawesome.com/ec12ae770c.js" crossorigin="anonymous"></script> --}}
    <script>
        $(document).ready(function() {     
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            $('.fa-thumbs-up').click(function(){    
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

{{-- <script>
    function myFunction(x) {
  x.classList.toggle("fa-thumbs-down");
} 
</script> --}}
{{-- <script>
    function myFunction(x) {
    x.classList.toggle("fa-thumbs-down");
    }
</script> --}}
@endsection

