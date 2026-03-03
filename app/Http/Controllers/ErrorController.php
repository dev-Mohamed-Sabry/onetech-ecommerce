<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ErrorController extends Controller
{
    public function error_403()
    {
        return view('errors.403');
    }

    public function error_404()
    {
        return view('errors.404');
    }
}
