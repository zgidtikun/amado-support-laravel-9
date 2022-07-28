<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Auth;
use Session;

class LoginController extends Controller
{
    
    protected $redirectTo = RouteServiceProvider::HOME;
    
    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    public function index(){
        return view('auth.login');
    }

    public function authenticate(Request $request){

        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        
        $credentials = $request->only('username', 'password');
        if(Auth::attempt($credentials)){
            return redirect()->intended('home');
        }

    }

    public function logout(){
        Session::flush();
        Auth::logout();  
        return Redirect('login');
    }
}
