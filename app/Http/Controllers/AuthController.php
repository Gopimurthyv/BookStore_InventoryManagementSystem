<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request){
        $request->validate([
            "name"=>"required|string|min:2",
            "email"=> "required|email",
            "password"=> "required|min:6|confirmed",
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::login($user);

        return redirect()->route('books.index')->with('success','User Register Successfully!');
    }

    public function login(Request $request){
        $request->validate([
            'email'=> 'required|email',
            'password'=> 'required'
        ]);

        $email = $request->email;
        $password = $request->password;

        if(Auth::attempt(['email'=>$email,'password'=>$password])){
            $user = User::where('email',$email)->first();
            Auth::login($user);
            return redirect()->route('books.index')->with('success','User Login Successfully');
        } else {
            return back()->withErrors('Invalid Credentials..');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}
