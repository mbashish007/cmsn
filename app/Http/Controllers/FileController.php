<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\CreateFileRequest;
use App\Http\Requests\RenameFileRequest;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateFileRequest $request)
    {
        // dd($request->repo);
        $path = $request->file->store('files');
        File::create([
            'name' => $request->file('file')->getClientOriginalName(),
            'file' => $path,
            'repo_id' => $request->repo,
        ]);

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(RenameFileRequest $request, File $file)
    {
        $this->authorize('update', $file);
        // dd($request->only('name'));// outputs vectored array
        $file->update($request->only('name'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $this->authorize('delete', $file);

        $file->deleteFile();
        $file->delete();
        session()->flash('success','Post Trashed Successfully');
        return redirect()->back();


    }
}
