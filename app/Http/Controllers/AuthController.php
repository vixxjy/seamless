<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }
    
    protected function sendResult($message, $data, $errors = [], $status = true)
    {
        $errorCode = $status ? 200 : 422;

        $result = [
            "message" => $message,
            "status" => $status,
            "data" => $data,
            "errors" => $errors
        ];

        return response()->json($result,$errorCode);
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $errors = [];
        $data = [];
        $message = "";
        $status = true;

        $validator = Validator::make($data, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = new User([
            'name' => $request->input('name'),
    		'email' => $request->input('email'),
    		'password' => bcrypt($request->input('password'))
        ]);
        
        $user->save();
         
        $token = $this->guard()->login($user);

        if (!$token) {
            $status = false;
            $errors = [
                "Registration" => "User registration was not successful",
            ];
            $message = "User Registration Failed";
        }else{
            $message = "User Registration was Successful";
            $data = $this->respondWithToken($token);
        }

        return $this->sendResult($message, $data, $errors, $status);
    }

    public function login(Request $request)
    {
        $data = $request->all();
        $errors = [];
        $data = [];
        $message = "";
        $status = true;

        $validator = Validator::make($data, [
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only("email", "password");

        if (!$token = $this->guard()->attempt($credentials)) {
            $status = false;
            $errors = [
                "login" => "Invalid username or password",
            ];
            $message = "Login Failed";
        }else{
            $message = "Login was Successful";
            $data = $this->respondWithToken($token);
        }

        return $this->sendResult($message, $data, $errors, $status);
    }

}
