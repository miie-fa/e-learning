<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::all();
        return view('pages.admin.videos.index',compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|max:255|string',
            'price' => 'required',
            'link' => 'required|max:255',
            'desc' => 'required'
        ]);

        Video::create($validate);

        return redirect()->route('admin.videos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        return view('pages.admin.videos.detail',compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $video = Video::find($id);
        return view('pages.admin.videos.edit',compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'title' => 'required|max:255|string',
            'price' => 'required',
            'link' => 'required|max:255',
            'desc' => 'required'
        ]);

        $video = Video::find($id);

        $video->update($validate);

        return redirect()->route('admin.videos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = Video::find($id);

        if($video->userVideo){
            $video->userVideo->delete();
        }

        $video->delete();

        return redirect()->route('admin.videos.index');
    }

    public function destroy_all(Request $request)
    {
        if($request->id){
            foreach($request->id as $key => $value){
                $video = Video::find($key);
    
                $video->delete();
            }
        }

        return redirect()->route('admin.videos.index');
    }
}
