@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div> --}}
            @foreach ($posts as $post)
                <div class="w3-container w3-card w3-white w3-round w3-margin"><br>
                    <img src="{{asset($post->user->profile_pic())}} " alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px">
                    <span class="w3-right w3-opacity">16 min</span>
                    <h4><a href="{{route('users.show',$post->user->id)}} ">{{$post->user->username}}</a></h4><br>
                    <p class="lead text-primary"><a href="{{route('posts.show',$post->id)}} ">{{$post->title}}</a></p>
                    <div class="gap-multiline-items-1 mt-2">
                        @foreach ($post->tags->take(9) as $tag)
                        <span class="badge badge-secondary px-2 py-1 bg-primary">{{$tag->name}} </span>
                        @endforeach  
                      </div>
                    <hr class="w3-clear">
                    <p>{{$post->content}}</p>
                    <div class="like-btn ml-2 pb-2 mb-2">
                        {{-- <i id="like{{$repo->id}}" data-id="{{ $repo->id }} " class="fa fa-thumbs-up {{(auth()->user()->hasLiked($repo)) ? 'liked' : ''}} "></i>  --}}
                        <a href="javascript:void(0);" id="like{{$post->id}}" data-id="{{ $post->id }} " class="fa fa-thumbs-up {{(auth()->user()->hasLiked($post)) ? 'liked' : ''}}"></a>
                        <div id="" class="cnt mx-1" style="display: inline"><span id="like{{$post->id}}-bs3" class="badge badge-pill badge-info text-white">{{ $post->likers()->count() }}</span></div>
                        <a href="javascript:void(0);" data-id="{{$post->id}} " class="fa fa-comment" role="button"></a>
                        <div id="" class="cnt mx-1" style="display: inline"><span id="cnt{{$post->id}}" class="badge badge-pill badge-warning text-white">{{ $post->comments->count() }}</span></div>
                    </div>
                    <div class="comment-div" id="comment-div{{$post->id}}">
                        <form action="{{route('createComment',$post->id)}} " id="form{{$post->id}}" method="post">
                            
                            <div class="form-group">
                                <textarea name="comment" class="form-control" id="comment{{$post->id}}" cols="0" rows="2" placeholder="Comment Here"></textarea>
                                <button type="submit" class="btn btn-outline-success mt-1">Comment</button>
                            </div>
                        </form>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" id="alert{{$post->id}}" role="alert">
                        <strong>Commented Successfully!</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    {{-- <button type="button" class="w3-button w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i>  Like</button>  --}}
                    {{-- <button type="button" class="w3-button w3-theme-d2 w3-margin-bottom"><i class="fa fa-comment"></i>  Comment</button>  --}}
                </div>
            @endforeach
              
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    html, body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}
    .like-btn {
        margin-top: 1px;
    }
    
    .alert {
        display: none;
    }
    .comment-div {
        display: none;
    }

    .cnt {
        margin-top: -1.5px;
    }
        
    .fa{
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

    .fa-thumbs-up {
        /* color: rgb(134, 205, 252); */
        /* color: rgb(66, 61, 143);
        background: #ccc; */
    }

    .fa-comment {
        color: rgb(19, 243, 49);
        background: #eee;
    }
    .fa-thumbs-up:hover {
        text-decoration: none;
        background: #eee;
    }

    .fa-comment:hover {
        text-decoration: none;
        background: yellow;
        color: white;
    }

    .liked {
        color: blue;
        background: #eee;
        text-decoration: none;
    }

    .liked:hover {
        color: red;
    }


</style>

@endsection

@section('js')
    <script>
        $(document).ready(function() {     
            var formName;
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
                url:'/posts/like',
                data:{id:id},
                success:function(data,status){
                        if(data.liked){
                            $(cObj).addClass('liked');
                            $('#'+cObjId+'-bs3').html(parseInt(c)+1);
                        }
                        else {
                            $(cObj).removeClass('liked');
                            $('#'+cObjId+'-bs3').html(parseInt(c)-1);
                        }
                    
                    }
                });
            }); 

            $('.fa-comment').click(function(){
                // var id = $(this).data('id');
                var id = $(this).data('id');
                var cnt = $('#cnt'+id).html();
                formName = '#form'+id;
                $('#comment-div'+id).toggle(400); 
                // alert(formName);  
            
                $('form').submit(function(e) { 

                    e.preventDefault(); // avoid to execute the actual submit of the form.

                    var form = $(this);
                    var url = form.attr('action');
                    var d = $('#comment'+id).val();
                    // alert(d);
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(), // serializes the form's elements.
                        // data: { comment:d},
                        success: function(data)
                        {
                            $('#comment-div'+id).toggle(400); // show response from the php script.
                            $('#cnt'+id).html(parseInt(cnt)+1);
                            $('#alert'+id).toggle(600);
                        }
                        });
                });
            });                                       
        }); 
    </script>
@endsection
