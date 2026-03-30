<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\json;

class FrontendController extends Controller
{

    private function categories()
    {
        return Category::orderBy('order', 'asc')->get();
    }

    public function index()
    {
        // $categories = Category::select('name', 'order')->orderBy('order', 'asc')->get();
        return view('Frontend.index', ['categories' => $this->categories()]);
    }

    public function contact()
    {
        return view('Frontend.contact', ['categories' => $this->categories()]);
    }
    public function blog()
    {
        return view('Frontend.blog', ['categories' => $this->categories()]);
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



}