<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WorkController extends Controller
{
    public function index()
    {

    }

    public function store()
    {
        //$data = Http::get('http://www.mocky.io/v2/5d47f24c330000623fa3ebfa');
        $work = new Work();
        $work->name = 'deneme';
        $work->difficulty = 2;
        $work->time = 5;
        $work->save();
    }
}
