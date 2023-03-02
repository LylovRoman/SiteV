<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function self()
    {
        $user = Auth::user();
        return response()->json([
            "first_name" => $user->first_name,
            "last_name" => $user->last_name,
            "phone" => $user->phone,
            "document_number" => $user->document_number
        ],200);
    }
}
