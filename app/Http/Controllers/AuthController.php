<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\fonnte;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class AuthController extends Controller
{
        use fonnte;
        /**
     * Handle an authentication attempt.
     */
        public function login_page()
        {
            return view('pages.auth.login');
        }
        public function register_page()
        {
            return view('pages.auth.register');
        }
        public function authenticate(Request $request): RedirectResponse
        {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $user = User::where('email',$request->email)->first();

            if($user && $user->active == 0){
                return redirect()->route('activication');
            }
    
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
    
                return redirect()->intended('/');
            }
    
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        public function register(Request $request)
        {
            $data = $request->validate([
                'name' => ['required', 'max:50', 'string'],
                'email' => ['required', 'email'],
                'phone' => ['required','unique:users,phone'],
                'password' => ['required', 'confirmed'],
            ]);

            $data['token'] = rand(111111,999999);
            if(Str::substr($request->phone,0,1) == 0){
                $phone = explode('0',$request->phone);
                $lastPhone = next($phone);
                $data['phone'] = '62'.$lastPhone;
            }

            $user = User::create($data);

            $messages = "Verivication ur Account $user->token";

            $this->send_message($user->phone,$messages);

            try{
                return redirect()->route('activication');
            }catch(\Throwable $th){
                throw $th;

                return back()->withInput();
            }

            return back()->withInput();
        }

        public function activication()
        {
            return view('pages.auth.activication');
        }

        public function activication_process(Request $request)
        {
            $user = User::where('token',$request->token)->first();

            if($user){
                $user->update([
                    'active' => 1
                ]);
                return redirect()->route('login');
            }
            return redirect()->back()->with('error','Token Tidak Sesuai');
        }
        public function logout()
        {
            Auth::logout();

            return redirect()->route('login');
        }
}
