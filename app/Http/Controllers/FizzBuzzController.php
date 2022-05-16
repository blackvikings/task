<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FizzBuzzController extends Controller
{
    public function getFizzBuzz()
    {
        return view('fizzbuzz');
    }
    public function fizzbuzz(Request $request)
    {
        $request->validate([
            'number' => 'integer',
        ]);

        if ($request->number % 15 == 0)
            echo "FizzBuzz" . "  ";

        else if (($request->number % 3) == 0)
            echo "Fizz" . "  ";

        else if (($request->number % 5) == 0)
            echo "Buzz" . "  ";

        else
            echo $request->number,"  " ;
    }
}
