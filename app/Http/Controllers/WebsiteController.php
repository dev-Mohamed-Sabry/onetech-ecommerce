<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class WebsiteController extends Controller
{
    public function index()
    {
        return view('Website.index');
    }

    public function contact()
    {
        return view('website.contact');
    }
    public function blog()
    {
        return view('website.blog');
    }
    public function user_login(Request $request)
    {
        $method = $request->isMethod('post');

        if ($method) {
            return response()->json($request->all());
        } else {
            return redirect()->route('home');
        }
    }
}