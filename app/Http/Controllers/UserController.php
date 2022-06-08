<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function createUser(Request $request)
    {
        try {
            Log::info('Init create User');
            $validator = Validator::make($request->all(), [  
                'familyName'=>'required|string',
                'name' => 'required|string',
                'birthday' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
    
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 418);
            };

            $newUser = new User();  
            $newUser->familyName = $request->familyName;
            $newUser->name = $request->name;
            $newUser->birthday = $request->birthday;
            $newUser->email=$request->email;
            $newUser->password=$request->password;  
            $newUser->rol= 'admin';                                   
            
            $newUser->save();

        return response()->json(["data"=>$newUser, "success"=>'User created'], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to create user->'.$th->getMessage());

            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }

    public function getAllUsers()
    {
        try {
            Log::info('Get all users');
        

            $user = User::all(); 

            if(empty($user)){
                return response()->json(
                    ["success" => "There are not users" ], 202);
            };

  

            return response()->json($user, 200);

        } catch (\Throwable $th) {
            Log::error('Failed to get all users->'.$th->getMessage());

            return response()->json(['error'=> 'Ups! Something wrong'], 500);
        }
    }

    public function getUserById ($id)
    {
        try {
            Log::info('Init get user by Id');

            $user = DB::table('users')->where('id',$id)->get();

            if(empty($user)){
                return response()->json(
                    [ "error" => "user not exists" ],404 );
            };

            return response()->json($user, 200);

        } catch (\Throwable $th) {
            Log::error('Failed to get user->'.$th->getMessage());

            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }

    public function updateUserById(Request $request, $id)
    {
        try {
            Log::info('Update data user');

           $validator = Validator::make($request->all(), [  
            'familyName'=> 'string|max:100',
            'name' => 'string|max:100',
            'birthday'=> 'string',
            'email' => 'email',
            'password' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 418);
        };
        
        $user = User::where('id',$id)->first();

        if(empty($user)){
            return response()->json(["error"=> "contact not exists"], 404);
        };

        if(isset($request->familyName)){
            $user->familyName = $request->familyName;};
            
        if(isset($request->name)){
            $user->name = $request->name;};
           
        if(isset($request->birthday)){
            $user->birthday = $request->birthday;};
            
        if(isset($request->email)){
            $user->email = $request->email;};
           
        if(isset($request->password)){
            $user->password = $request->password;};
           
        $user->save();

        return response()->json(["data"=>$user, "success"=>'User updated'], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to update user data->'.$th->getMessage());
            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }

    public function deleteUserById ($id)
    {
        try {
            Log::info('delete user');
            $user = User::where('id',$id)->first();

            if(empty($user)){
                return response()->json(["error"=> "user not exists"], 404);};

            $user->delete();

            return response()->json(["data"=> "user deleted"], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to delete user->'.$th->getMessage());
            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }
}
