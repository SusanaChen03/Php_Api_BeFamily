<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    public function createUserMember(Request $request) //family member create
    {
        try {
            Log::info('Init create Member');
            $validator = Validator::make($request->all(), [
                'familyName' => 'required|string',
                'name' => 'required|string',
                'birthday' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if ($validator->fails()) {

                return response()->json(["data" => $validator->errors(), "success" => false], 418);
            };

            $newMember = new User();
            $newMember->familyName = $request->familyName;
            $newMember->name = $request->name;
            $newMember->birthday = $request->birthday;
            $newMember->email = $request->email;
            $newMember->password = $request->password;
            $newMember->rol = 'user';


            $newMember->save();

            return response()->json(["data" => $newMember, "success" => true], 200);
        } catch (\Throwable $th) {
            Log::error('Failed to create user->' . $th->getMessage());

            return response()->json(['error' => 'Ups! Something wrong' . $th], 500);
        }
    }

    public function getAllMembers($familyName)
    {
        try {
            Log::info('Get all members');


            $user = DB::table('users')->where('familyName', $familyName)->get();

            if (empty($user)) {
                return response()->json(
                    ["success" => "There are not users"],
                    202
                );
            };

            return response()->json($user, 200);
        } catch (\Throwable $th) {
            Log::error('Failed to get the members->' . $th->getMessage());

            return response()->json(['error' => 'Ups! Something wrong' . $th], 500);
        }
    }
};
