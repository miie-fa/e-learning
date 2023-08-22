<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserVideo;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index(){
        $videos = Video::get();

        return view('pages.user.videos', compact('videos'));
    }

    public function index_my_video() {
        $auth = Auth::user();

        $videos = UserVideo::where('user_id', $auth->id)->get();

        return view('pages.user.videos', compact('videos'));
    }
}
