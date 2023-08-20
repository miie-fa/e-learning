<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(Auth::user()->id);
        
        return view('pages.admin.setting', compact('user'));
    }

    public $user;

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $validated = $request->validate([
            'name' => 'required|max:255|string',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
        ]);

        $this->user->update($validated);

        return redirect()->back();
    }

    public function change_password(){
        return view('pages.admin.change_password');
    }

    public function change_password_update(Request $request){
        $user = User::find(Auth::user()->id);

        $validated = $request->validated([
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, $user->password)){
            
        }
        }





    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pages.admin.change');
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
