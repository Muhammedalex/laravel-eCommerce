<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ConfirmRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Notifications\SendOTP;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    private $otp;
    public function __construct()
    {
        $this->otp = new Otp;
    }

    public function register(RegisterRequest $request){
        $valid = $request->validated();
        try{
            $valid['password'] = Hash::make($valid['password']);
            $user = User::create($valid);
            $user->notify(new SendOTP());
            return response(['success'=>true , 'data' =>$user],201);
        } catch(\Exception $e){
            return response(['success'=>false , 'message' =>$e->getMessage()]);
        }
    }

    public function confirm(ConfirmRequest $request)
    {
        try{
            $user = User::where('email', $request->email)->first();
        $otpe = $this->otp->validate($request->email, $request->otp);
        // dd($otpe->status);
        if (!$otpe->status) {
            return response(['error' => 'something went wrong', 'status' => $otpe], 404);
        }
        if($user->isActive == true){
            
            return response(['error' => 'This Account Already Verified'] , 404);
        }
        $user->isActive = true;
        $user->save();
        return response(['message' => 'Account Have Been Activeted'], 200);
        } catch(\Exception $e){
            return response(['success'=>false , 'message' =>$e->getMessage()]);
        }
    }
}
