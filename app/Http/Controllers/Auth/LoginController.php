<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class LoginController extends Controller
{

    public function getLogin(){
        $hashedPassword = Hash::make('1234567');
        //dd($hashedPassword);
        return view('login');
    }

    public function postLogin(Request $request){
        try {
            $message = trans('messages.invalid_login_credentials');
            $rememberMe = false;
    
            // Retrieve user by email
            $user = User::where('email', $request->email)->where('status',1)->first();
            
            if ($user->password) {
                // Check if the provided password matches the stored password
                if (Hash::check($request->password, $user->password)) {
                    // Log the user in and redirect to dashboard
                    //dd($user->id);
                    Auth::loginUsingId($user->id, $rememberMe);
                    return redirect('http://127.0.0.1:8000/dashboard');
                } else {
                    // Password does not match, redirect to error page
                    return redirect('/Error')->withErrors(['password' => $message]);
                }
            } else {
                // User not found, redirect to error page
                return redirect('/Error')->withErrors(['email' => $message]);
            }
        } catch (\Exception $e) {
            // Handle unexpected errors
            return redirect('/Error')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function logoutUser(Request $request){
        Auth::logout();
       
        return redirect('/login');
    }

}