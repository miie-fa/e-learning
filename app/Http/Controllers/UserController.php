<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        return view('pages.admin.users.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255|string',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:admin,teacher,user',
            'password' => 'required|confirmed'
        ]);

        $validate['password'] = Hash::make($request->password);

        User::create($validate);

        return redirect()->route('admin.user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        $userVideos = UserVideo::with(['user','videos'])->where('user_id',$id)->get();
        return view('pages.admin.users.show',compact('user','userVideos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('pages.admin.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'name' => 'required|max:255|string',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,teacher,user'
        ]);

        $user = User::find($id);

        $user->update($validate);

        return redirect()->route('admin.user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        $user->delete();

        return redirect()->route('admin.user.index');
    }

    public function destroy_all(Request $request)
    {
        if($request->id){
            foreach($request->id as $key => $value){
                $user = User::find($key);
    
                $user->delete();
            }
        }

        return redirect()->route('admin.user.index');
    }
}
