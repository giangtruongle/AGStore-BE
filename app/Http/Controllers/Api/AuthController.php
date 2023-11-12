<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\Contracts\HasApiTokens;

class AuthController extends Controller
{
     /**
     * Create User
     * @param Request $request
     * @return User 
     */
    public function register(Request $request)
    {
            //Validated
            $validator = Validator::make($request->all(), 
            [
                'name' => 'required|max:255|min:4',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|min:8|max:30'
            ]);

            if($validator->fails()){
                return response()->json([
                    'validation_errors'=>$validator->messages(),
                ]);
            }else{
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]);

            $token = $user->createToken($user->email.'_gaodo')->plainTextToken;

                return response()->json([
                    'status' => 200,
                    'username'=>$user->name,
                    'message' => 'Register Successfully',
                    'token' => $token
                ]);
            }
    }
    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function login(Request $request)
    {
            $validator = Validator::make($request->all(), 
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validator->fails()){
                return response()->json([
                    'validation_errors'=>$validator->messages(),
                ]);
            }else{
                $user = User::where('email', $request->email)->first();

                if(!$user || !Hash::check($request->password, $user->password)){
                    return response()->json([
                        'status' => 401,
                        'message' => 'Invalid Credentials',
                    ]);
                }else{
                    if($user->role === 1){
                        $role = 'admin';
                        $token = $user->createToken($user->email.'_AdminToken',['sever:admin'])->plainTextToken;
                    }else{
                        $role = '';
                        $token = $user->createToken($user->email.'_Token',[''])->plainTextToken;
                    }
                    return response()->json([
                        'status'=>200,
                        'username'=>$user->name,
                        'useremail'=>$user->email,
                        'token'=>$token,
                        'role'=>$role,
                        'message'=>'Loged in Successfully',
                    ]);
                }
            }
    }

    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Loged Out Successfully!'
        ]);
    }
}