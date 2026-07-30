<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function help()
    {
        // Vista principal
        return view('user.help');
    }
}
