<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TerminosController extends Controller
{
    public function terminos()
    {
        // Vista principal
        return view('user.terminos');
    }
}
