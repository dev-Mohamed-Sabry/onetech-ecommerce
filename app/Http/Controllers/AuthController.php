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
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\URL;

use Spatie\Permission\Guard;
use function Pest\Laravel\json;

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

            //  مهمة جدًا —  Email Verification إرسال 
            event(new Registered($user));

            $user->assignRole('user');
            // لو عايز تسجله دخول تلقائي
            // Auth::login($user);

            DB::commit();

            return response()->json([
                'status' => true,
                'role' => 'user',
                'message' => 'Registered Successfully, Waiting For Verification',
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'message' => 'Something Went Wrong'
            ], 500);
        }
    }

    public function verify_register(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            abort(403);
        }

        if (!$request->hasValidSignature()) {
            abort(403);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }
        return view('auth.verified-success');
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

        $user = Auth::Guard('web')->user();
        if (!$user->hasVerifiedEmail()) {
            Auth::logout();
            return response()->json([
                'status' => false,
                'message' => 'Please Verify Your Email First',
            ], 403);
        }

        $request->session()->regenerate();


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
            $user = User::where('email', '=', $request->email)->first();

            if (isset($user)) {

                // ID encryption
                $url = URL::temporarySignedRoute(
                    'user.update.password', // اسم الروت
                    now()->addMinutes(30),  // مدة الصلاحية
                    ['id' => $user->id]    // البراميتر
                );

                Mail::to($user->email)->send(new ForgetPassword($url));

                return response()->json([
                    'data' => true,
                ]);
            } else {
                return   response()->json([
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

    public function user_store_new_password(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            $user = User::findOrFail($request->id);
            $user->update([
                'password' => $request->password,
            ]);
            DB::commit();

            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json(
                [
                    'message' => 'Something Went Wrong'
                ],
                500
            );
        }
    }
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}