<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Param;

class DemoController extends Controller
{
    public function index()
    {
        return view('demoindex');
    }

    public function index2()
    {
        $data = "ABC";
        return view('demoindex2', compact('data'));
    }

    public function index3()
    {
        return response()->json([
            'status' => 'true',
            'data' => [
                'name' => 'San Pham 1',
                'price' => 24000
            ]
        ]);
    }

    public function index4($id)
    {
        $data = "ABC";
        return view('demoindex4', compact('data', 'id'));
    }

    public function index5($id = null)
    {
        $data = "ABC";
        dump($id);
        return view('demoindex5', compact('data', 'id'));
    }

    public function index6($parram1, $parram2)
    {
        $data = "ABC";
        return view('demoindex6', compact('data', 'parram1', 'parram2'));
    }
}