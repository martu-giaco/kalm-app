<?php
namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function home()
    {
        // Vista principal
        return view('user.home');
    }
}
