<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        if(auth::id())
        {
            $userType=Auth::user()->userType;
            if($userType=='admin')
            {
                return view('home');
            }
            else
            {
                return view('main');
            }
        }
        
    }
}
