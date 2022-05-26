<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ChallengeController extends Controller
{
    public function createChallenge(Request $request)
    {
        try {
            Log::info('Init create challenge');
            $validator = Validator::make($request->all(), [   
                'name' => 'required|string',
                'repeat' => 'required|integer',
                'reward'=> 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 418);
            };

            $newChallenge = new Challenge();
            $userId = auth()->user()->id;
            $newChallenge->familyName = $request->familyName;
            $newChallenge->name = $request->name;
            $newChallenge->repeat = $request->repeat;
            $newChallenge->reward = $request->reward;
            $newChallenge->member_id = $request->member_id;
            $newChallenge->user_id=$userId;  

            $newChallenge->save();

            return response()->json(["data"=>$newChallenge, "success"=>'Challenge created'], 200);
     
        } catch (\Throwable $th) {
            Log::error('Failed to create the challenge->'.$th->getMessage());

            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }
  
}
