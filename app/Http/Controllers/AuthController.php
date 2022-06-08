<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            Log::info('Init register user');

            $validator = Validator::make($request->all(), [  
                'familyName'=>'required|string',
                'name' => 'required|string',
                'birthday' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
            ]);


            if ($validator->fails()) {
                return response()->json($validator->errors()->toJson(), 418);
            }

            $user = User::create([
                'familyName'=>$request->get('familyName'),
                'name' => $request->get('name'),
                'birthday' => $request->get('birthday'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->password),
                'rol'=> 'admin'
            ]);
            
            
            $token = JWTAuth::fromUser($user);
            return response()->json(compact('user', 'token'), 201);
        } catch (\Throwable $th) {
            Log::error('Failed to register user->' . $th->getMessage());

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            Log::info('Init login');
            $input = $request->only('email', 'password');

            $jwt_token = null;
            
            if (!$jwt_token = JWTAuth::attempt($input)) {
                Log::info('HTTP_UNAUTHORIZED login');
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Email or Password',
                ], Response::HTTP_UNAUTHORIZED);
            };
            $user = DB::table('users')->where('email',$request->get('email'))->first();

            if(empty($user)){
                return response()->json(
                    [ "error" => "user not exists" ],404 );
            };

            Log::info('fin login');
            return response()->json(['success' => true, 'user' => $user,'token' => $jwt_token]);

        } catch (\Throwable $th) {

            Log::error('Failed to login user->' . $th->getMessage());

            return response()->json(['error=> "Error login user'], 500);
        }
    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            Log::info('Init Logout');
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function profile()
    {
        try {
            Log::info('Init Get Profile');

            return response()->json(auth()->user());

        } catch (\Throwable $th) {

            Log::error('Failed to get your profile->' . $th->getMessage());

            return response()->json(['error=> Error to get profile'], 500);
        }
    }
}
