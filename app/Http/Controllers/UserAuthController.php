<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    //


        public function showLogin(){
        return response()->view('cms.auth.login');
    }


    // public function login(Request $request)

    // {

    //     $validator = Validator($request->all(), [
    //         'email' => 'required|email|string',
    //         'password' => 'required|string|min:3',
    //         'remember_me' => 'required|boolean',
    //     ], [
    //         'email.required' => 'Email is required',
    //         'email.email' => 'Please enter the correct e-mail',
    //         'password.required' => 'Password is required',
    //     ]);
    //     $credentials = [
    //         'email' => $request->get('email'),
    //         'password' => $request->get('password'),
    //     ];
    //     if (!$validator->fails()) {
    //         if (Auth::attempt($credentials, $request->get('remember_me'))) {
    //             return response()->json(['icon' => 'success', 'title' => 'Login Successfully'], 200);
    //         } else {
    //             return response()->json(['icon' => 'error', 'title' => 'Login Faild'], 400);
    //         }
    //     } else {
    //         return response()->json(['message' => $validator->getMessageBag()->first()], 400);
    //     }

    // }



    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();

        return response()->json(['success' => true]);
    }

    return response()->json([
        'errors' => ['email' => ['بيانات الدخول غير صحيحة']]
    ], 422);
}


    public function logout(Request $request)

    {

        Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('cms.login');

    }


}
