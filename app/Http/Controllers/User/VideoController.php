<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\UserVideo;
use App\Models\Video;
use App\Traits\Ipaymu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    use Ipaymu;

    public function index()
    {
        $videos = Video::get();
        return view('pages.user.videos',compact('videos'));
    }

    public function index_my_video()
    {
        $auth = Auth::user();
        $videos = UserVideo::where('user_id',$auth->id)->get();
        return view('pages.user.my_videos',compact('videos'));
    }

    public function pay($id)
    {
        $video = Video::find($id);

        $payment = json_decode(json_encode($this->redirect_payment($id)), true);

        dd($payment);

        Transaction::create([
            'user_id' => Auth::user()->id,
            'video_id' => $video->id,
            'status' => 'PENDING',
            'no_invoice' => $payment['Data']['SessionID'],
            'link' => $payment['Data']['Url'],
            'amount' => $video->price,

        ]);
    }
}
