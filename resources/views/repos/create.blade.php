@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Repositry</div>

                <div class="card-body">
                    <form @isset($repo)
                    action="{{route('repos.update',$repo->slug)}}"
                    @else
                        action="{{route('repos.store')}}"
                    @endisset
                     method="post">
                        @csrf
                        @isset($repo)
                            @method('PUT')
                        @endisset
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$repo->name}}" >
                            
                        </div>
                        @if ($tags->count() > 0 )
                            <div class="form-group">
                                <label for="tags">Tags</label>
                                <select name="tags[]" id="tags" class="form-control tag-selector" multiple>
                                    @foreach ($tags as $tag)
                                        <option value="{{$tag->id}}"
                                            @isset($repo)
                                                @if ($repo->hasTag($tag->id))
                                                    selected
                                                @endif
                                            @endisset
                                            >{{$tag->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <button class="btn btn-success mt-2" type="submit">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endsection
    
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.tag-selector').select2();
        })
    </script>
@endsection


