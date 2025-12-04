<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Routine;
use App\Models\RoutineType;

class TestResultController extends Controller
{
    public function show($testKey)
    {
        $resultKey = session('result_key'); // 'normal', 'seco', etc.

        $routine = Routine::whereHas('types', function($q) use ($resultKey) {
            $q->where('name', $resultKey);
        })->with('products.brand')->first();

        return view('tests.result', compact('routine', 'resultKey', 'testKey'));
    }
}
