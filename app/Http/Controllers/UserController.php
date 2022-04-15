<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        // return response()->json(User::all());
        return UserResource::collection(User::paginate(5));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=> ['required','email'],
            'password' => ['required', 'min:8'],
        ]);
        $user=User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // return response()->json(array_merge($user->toArray(),['requested at'=> now()]));
        return UserResource::make($user)-> additional([
            'toker' => Str::random(32),
        ]);
    }
}
