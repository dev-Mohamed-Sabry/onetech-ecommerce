<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\json;

class FrontendController extends Controller
{
    public function index()
    {
        return view('Frontend.index');
    }

    public function contact()
    {
        return view('Frontend.contact');
    }
    public function blog()
    {
        return view('Frontend.blog');
    }
    // public function user_login(Request $request)
    // {
    //     $method = $request->isMethod('post');

    //     if ($method) {
    //         $check = $request->only('email', 'password');
    //         if (Auth::guard('web')->attempt([
    //             'email' => $check['email'],
    //             'password' => $check['password'],
    //         ])) {
    //             $user = Auth::user();
    //             if (Auth::user()->hasRole('admin')) {
    //                 return response()->json(['data' => 1]); //admin
    //             } else {
    //                 // Auth::login($user);
    //                 return response()->json(['data' => 2]); //user
    //             }
    //         } else {
    //             return response()->json(['data' => 0]); //invalid credentials
    //         }
    //         // return response()->json($request->all());
    //     } else {
    //         return redirect()->route('home');
    //     }
    // }


    public function user_login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $check = $request->only('email', 'password');

        if (!Auth::attempt($check)) {
            return response()->json([
                'status'  => false,
                'message' => 'Wrong Email Or Password',
            ], 401); // invalid credentials
        }

        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return response()->json([
                'status' => true,
                'role'   => 'admin'
            ]); // admin
        }

        return response()->json([
            'status' => true,
            'role'   => 'user'
        ]); // user
    }
}
