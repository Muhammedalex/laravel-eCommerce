<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request){
        $valid = $request->validated();
        try{
            $valid['password'] = Hash::make($valid['password']);
            $user = User::create($valid);
            return response(['success'=>true , 'data' =>$user],201);
        } catch(\Exception $e){
            return response(['success'=>false , 'message' =>$e->getMessage()]);

        }
    }
}