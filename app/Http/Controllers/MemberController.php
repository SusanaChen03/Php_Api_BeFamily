<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;


class MemberController extends Controller
{
    public function createUserMember(Request $request) //family member create
    {
        try {
            Log::info('Init create User');

            $member = $request->all();

            $newMember = User::create($member);

            return response()->json(["data" => $newMember, "success" => 'User created'], 200);
        } catch (\Throwable $th) {
            Log::error('Failed to create user->' . $th->getMessage());

            return response()->json(['error' => 'Ups! Something wrong'], 500);
        }
    }
}
