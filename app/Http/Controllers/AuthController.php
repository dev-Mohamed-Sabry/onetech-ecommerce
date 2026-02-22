<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use App\Mail\ForgetPassword;

class AuthController extends Controller
{

    public function register_page()
    {
        return view('auth.register');
    }
    public function register_method(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            $user->assignRole('user');
            // لو عايز تسجله دخول تلقائي
            Auth::login($user);

            DB::commit();

            return response()->json([
                'status' => true,
                'role' => 'user',
                'message' => 'Registered Successfully'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Something Went Wrong'
            ], 500);
        }
    }

    public function login_page()
    {
        return view('auth.login');
    }
    public function login_method(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status'  => false,
                'message' => 'Wrong Email Or Password',
            ], 401); // invalid credentials
        }

        $request->session()->regenerate();
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

    public function user_forgot_password()
    {
        return view('auth.forgot-password');
    }

    public function user_reset_password(Request $request)
    {

        if ($request->isMethod('POST')) {
            // هل البريد موجود في قاعدة البيانات ولا لا
            // return response()->json(['data' => $request->only('email')]);
            $check = User::find($request->email);

            if (isset($check)) {
                // return response()->json($check);
                Mail::to($check->email)->send(new ForgetPassword(route('user.update.password', ['id' => $check->id])));
            } else {
                return    response()->json([
                    'data' => false
                ]);
            };
        } else {
            return redirect()->route('home');
        }
    }

    public function user_update_password($id)
    {
        return view('auth.update-password', ['id' => $id]);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}