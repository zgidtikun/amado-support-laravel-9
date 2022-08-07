<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;
    
    public function __construct(){
        // $this->middleware('guest');
    }

    public function index(){
        return view('auth.register');
    }

    public function registration(Request $request){

        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],            
            'rule' => ['required', 'string']
        ]);

        if($this->create($request->all()))
            return redirect()->intended('login');

    }    
    
    protected function create(array $data){
        return User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'rule' => $data['rule'],
        ]);
    }    

    public function reset_password(Request $request)
    {
        try{
            $result = User::where('username',$request->input('username'))
                ->update([ 'password' => Hash::make('Amado.1234') ]);
        }
        catch(QueryException $e){ $errormsg = $e->getMessage(); }

        return response()->json([
            'status' => isset($result) ? $result  : false,
            'message' => isset($errormsg) ? $errormsg : ''
        ], 200);

    }
}
