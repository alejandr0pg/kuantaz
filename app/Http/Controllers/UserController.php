<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            [
                'code' => 200,
                'success' => true,
                'data' => [
                    'usuarios' => User::all()
                ]    
            ]
        );
    }
}
