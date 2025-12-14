<?php

namespace App\Http\Controllers;

use App\Models\Postes;
use Illuminate\Http\Request;

class ApiPostController extends Controller
{
    public function index()
    {
        return response()->json(Postes::all());
    }
}
