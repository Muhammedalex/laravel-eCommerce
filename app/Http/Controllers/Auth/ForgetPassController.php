<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgetPassRequest;
use App\Http\Requests\Auth\ResetPassRequest;
use App\Models\User;
use App\Notifications\ResetPassOTP;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForgetPassController extends Controller
{

    private $otp;
    public function __construct()
    {
        $this->otp = new Otp;
    }

    public function forgotPass(ForgetPassRequest $request)
    {
        $input = $request->only('email');
        $user = User::where('email',$input)->first();
        $user->notify(new ResetPassOTP());
        // $success['success']=true;
        return response(["success"=>true],200);
    }

    public function resetPass(ResetPassRequest $request)
    {
        $otpe = $this->otp->validate($request->email , $request->otp);
        dd($otpe);
        if(!$otpe->status){
            return response(['error'=>$otpe],401);
        }
        $user = User::where('email',$request->email)->first();
        $user->update(['password'=>Hash::make($request->password)]);
        $user->tokens()->delete();
        $success['success']=true;
        return response($success,201);
    }
}
