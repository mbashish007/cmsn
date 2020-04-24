<?php

namespace App\Http\Controllers;

use App\Repo;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\CreateRepoRequest;
use App\Http\Requests\UpdateRepoRequest;

class RepoController extends Controller
{

    // 'slug' => Str::of($request->title)->slug('-')
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('repos.index',['repos' => Repo::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('repos.create',['tags' => Tag::all()]);   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRepoRequest $request)
    {
        //  dd(Str::of($request->name.' '.auth()->user()->name)->slug('-'));
        $repo = auth()->user()->repos()->create([
            'name' => $request->name,
            'slug' => Str::of($request->name.' '.auth()->user()->name)->slug('-')
        ]);

        if($request->tags){
            $repo->tags()->attach($request->tags);
        }

        return redirect(route('repos.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Repo  $repo
     * @return \Illuminate\Http\Response
     */
    public function show(Repo $repo)
    {
        return view('repos.show',['repo'=>$repo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Repo  $repo
     * @return \Illuminate\Http\Response
     */
    public function edit(Repo $repo)
    {
        return view('repos.create',['repo' => $repo ,'tags' => Tag::all()]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Repo  $repo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRepoRequest $request, Repo $repo)
    {
        // $names = Repo::all()->except($repo->id)
        // ->pluck('name')->toArray();
        // dd($names);

        $repo->update([
            'name' => $request->name,
            'slug' => Str::of($request->name.' '.auth()->user()->name)->slug('-'),
        ]);

        if($request->tags){
            $repo->tags()->sync($request->tags);
        }

        return redirect()->route('repos.show',['repo' => $repo]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Repo  $repo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repo $repo)
    {
        
    }

    public function addFile(){
        
    }
}
