<?php

namespace App\Http\Controllers;

use App\Post;
use App\Repo;
use App\Tag;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('posts.index',['posts'=>Post::all()]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create',['tags' => Tag::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        
        $post = auth()->user()->posts()->create([
            'title' => $request->title,
            'slug' => Str::of($request->title.' '.auth()->user()->username)->slug('-'),
            'content'=> $request->content
        ]);
        
        if($request->images){
            $post->attachImages($request->images);
        }

        if($request->tags){
            $post->tags()->attach($request->tags);
        }

        return redirect()->route('posts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // $id = $post->id;
        // $comments = Comment::whereHasMorph('commentable', '*', function (Builder $query, $type ) {
        //     if ($type === 'App\Post') {
        //         $query->where('commentable_id', $posti->id);
        //     }
        // })->get();
        // dd($comments);
        $comments = Comment::where('commentable_id',$post->id)
                    ->where('commentable_type','App\Post')
                    ->paginate(10);
        // dd($comment);
        return view('posts.show',['post'=>$post,'comments'=>$comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.create',['post'=>$post,'tags'=>Tag::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update([
            'title' => $request->title,
            'slug' => Str::of($request->title.' '.auth()->user()->username)->slug('-'),
            'content'=> $request->content
        ]);

        if($request->images){
            $post->updateImages($request->images);
        }
        if($request->tags){
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('posts.show',$post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->deletePost();

        return redirect()->route('posts.index');
    }

    public function likePost(Request $request) {
        $post = Post::find($request->id);
        auth()->user()->toggleLike($post);
        $response = auth()->user()->hasLiked($post); 
        // return response()->json(['or'=>$response]);
        return response()->json(['liked' => $response]);
    }

    public function likeComment(Request $request) {
        $comment = Comment::find($request->id);
        auth()->user()->toggleLike($comment);
        $response = auth()->user()->hasLiked($comment); 
        // return response()->json(['or'=>$response]);
        return response()->json(['liked' => $response]);
    }

    public function createComment(CreateCommentRequest $request, Post $post){
        $post->comments()->create([
            'content' => $request->comment,
            'user_id' => auth()->user()->id,
            ]);
    }

    public function deleteComment(Comment $comment){
        $comment->delete();
        return redirect()->back();
    }

    public function tp(){
        // $search = request()->query('tags');
        // dd($search);
        $tagids = request()->tags;
        $posts = Tag::find($tagids[0])->posts;
        $repos = Tag::find($tagids[0])->repos;

        foreach($tagids as $tagid){
            $tag = Tag::find($tagid);
            $posts = $posts->merge($tag->posts);
            $repos = $repos->merge($tag->repos);
        }

        return view('filter',['posts'=>$posts,'repos' => Repo::all()]);
    }

}
