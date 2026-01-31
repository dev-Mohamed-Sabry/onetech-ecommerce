<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}