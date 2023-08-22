<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $teachers = User::where('role', 'teacher')->get();

        return view('home', compact('teachers'));
    }
}
