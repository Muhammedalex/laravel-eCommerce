<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\RegisterRequest;
use App\Models\User;
use App\Traits\CheckRole;
use App\Traits\CustomResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use CustomResponse , CheckRole;
    //admin login
    public function admin_login(LoginRequest $request)
    {
        // $this->checkRole(['admin']);
        try{
            $user = User::where('email', $request->email)->first();
            if($user->role == 'user'){
                throw new AuthorizationException();
            }
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(['message' => 'Email or Password not correct'], 401);
        }
    
        $token = $user->createToken($user->first_name);
        return response([
            'message' => 'Hello ' .$user->first_name,
            'token' => $token->plainTextToken,
            'user' => $user,
        ], 201);
        } catch(\Exception $e){
            return response(['message' => $e->getMessage()], 401);

        }
    }
    //admin block user
    public function blockUser(Request $request ,User $user){

        $this->checkRole(['admin']);
    //    dd($user);
        try{
            // dd($user->block);
            if($user->block){
                $user->block =false;
                $user->save();
               return $this->create_response('User Unblocked',$user,203);

            }
            $user->block = true;
            $user->save();
           return $this->create_response('User Blocked',null,203);
        }catch(\Exception $e){
            return $this->error_response('Something Went Wrong', $e->getMessage(), 500);
        }
    }
    //create user
    public function createUser(RegisterRequest $request){
        $this->checkRole(['admin']);
        $valid = $request->validated();
        try{
            $valid['password'] = Hash::make($valid['password']);
            $user = User::create($valid);
            $user->isActive = 1;
            $user->save();
            return response(['success'=>true , 'data' =>$user],201);
        } catch(\Exception $e){
            return response(['success'=>false , 'message' =>$e->getMessage()]);
        }
    }
}
