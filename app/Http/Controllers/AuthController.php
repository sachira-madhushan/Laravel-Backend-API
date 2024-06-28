<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    //@des login user
    //@route POST /api/auth/login
    //@access public
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Incorrect credentials'], 401);
        }

        return $this->respondWithToken($token);
    }

    //@des register user
    //@route POST /api/auth/register
    //@access public
    public function register(Request $req){
        $user=new User;
        $user->name=$req->name;
        $user->email=$req->email;
        $user->password=bcrypt($req->password);

        $result=$user->save();
        if($result){
            return response()->json([
                'message'=>'User successfully registered',
                'user'=>$user
            ]);
        }else{
            return response()->json([
                'message'=>'Registration failed',
            ]);
        }
    }

    //@des user profile
    //@route GET /api/auth/me
    //@access private
    public function me()
    {
        return response()->json(auth()->user());
    }

    //@des user logout
    //@route GET /api/auth/logout
    //@access private
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    //@des refresh token
    //@route GET /api/auth/refresh
    //@access private
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


    //generate JWT token
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
