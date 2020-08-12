<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailUser;

class AuthController extends Controller
{

    private $user;
    private $service;


    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(User $user, AuthService $service)
    {
        $this->middleware('auth:api', ['except' => ['login','forgotPassword']]);
    
        $this->user = $user;
        $this->service = $service;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        try {


            $credentials = request(['email', 'password']);

            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
    
            return $this->respondWithToken($token);
        
        
        } catch (\Throwable $e) {
           
            return response()->json(['Error' => ''.$e, 'status' => 'false']);
        }
       
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }






    public function forgotPassword(Request $request)
    {
        
        $request->validate([
            'email' => 'required|string',
        ]);
     
        
        $user  = $this->user->where('email', $request->email)->first();
        
        if($user){
            
            $senha =  $this->service->makePassword(8,true,true,true,false);

            $user->password =  bcrypt($senha);
            
            $user->save();


             $status = Mail::to($user->email)->send(new SendMailUser($user, $senha));
             
            //$status = $this->service->sendEmail($senha , $user->email);
            
            //Mail::to('danielsp.pinto@gmail.com')
            //->send(new SendMailUser($user));
            
            return response()->json(['message'=> $status]);
        }
        else{
            return response()->json(['data' => 'Email nao cadastrado']);
        }

    }








    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
