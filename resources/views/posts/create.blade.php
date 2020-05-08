@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Post</div>

                <div class="card-body">
                    <form @isset($post)
                    action="{{route('posts.update',$post->id)}}"
                    @else
                        action="{{route('posts.store')}}"
                    @endisset
                     method="post" enctype="multipart/form-data">
                        @csrf
                        @isset($post)
                            @method('PUT')
                        @endisset
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" @isset($post)
                                value="{{$post->title}}"
                            @endisset >
                            
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            {{-- <textarea name="content" id="content" class="form-control" rows="10">@isset($post)
                                {{$post->content}}
                            @endisset</textarea> --}}
                            <input id="x" type="hidden" @isset($post)
                            value="{!!$post->content!!}"
                            @endisset name="content" placeholder="No Images">
                                <trix-editor input="x"></trix-editor>
                        </div>

                        <div class="form-group">
                            <label for="images">Image(s)</label>
                            <input type="file" name="images[]" id="images" multiple>
                            @isset($post)
                                <p class="text-danger">!! Images Cannot Be Changed If "Image Is Uploaded" Previous Images Will Be Deleted And Replaced With New Images. !!</p>
                            @endisset
                        </div>

                        @if ($tags->count() > 0 )
                            <div class="form-group">
                                <label for="tags">Tags</label>
                                <select name="tags[]" id="tags" class="form-control tag-selector" multiple>
                                    @foreach ($tags as $tag)
                                        <option value="{{$tag->id}}"
                                            @isset($post)   
                                                @if ($post->hasTag($tag->id))
                                                    selected
                                                @endif
                                            @endisset
                                            >{{$tag->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <button class="btn btn-success mt-2" type="submit">
                            @isset($post)
                                Update
                            @else
                                Create
                            @endisset
                        </button>
                    </form>
                    <form action="{{route('posts.destroy',$post->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger float-right">Delete</button>
                    </form>
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css">
    
@endsection
    
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>
    <script>
        $(document).ready(function() {
            $('.tag-selector').select2();
        })
    </script>
@endsection


