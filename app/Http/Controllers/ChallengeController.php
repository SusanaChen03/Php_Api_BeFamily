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

    public function getAllChallenge()
    {
        try {
            Log::info('Init get all Challenge');
            $userId = auth()->user()->id;

            $challenge = DB::table('challenges')->where('user_id', $userId)->get()->toArray();
            
            if(empty($challenge)){
                return response()->json(
                    [
                        "success" => "There are not challenges"
                    ], 202
                );
            };

            return response()->json($challenge, 200);
            
        } catch (\Throwable $th) {

            Log::error('Failed to get all the challenges->'.$th->getMessage());
            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);  
        }
    }

    public function getChallengeById($id) //busqueda por id del usuario 
    {
        try {
            Log::info('Init get Challenge by id');
            $userId = auth()->user()->id;

            $challenge = DB::table('challenges')->where('user_id',$userId)->where('user_id',$id)->get();

            if(empty($challenge)){
                return response()->json(
                    [
                        "error" => "Challenge not exists"
                    ],404
                );
            };

            return response()->json($challenge, 200);

        } catch (\Throwable $th) {
            Log::error('Failed to get challenge by id->'.$th->getMessage());

            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }

    public function updateChallengeById(Request $request, $id)
    {
        try {
            Log::info('Update Challenge by id');
            $userId = auth()->user()->id;

            $validator = Validator::make($request->all(), [   
                'name' => 'string|max:100',
                'repeat' => 'integer|max:100',
                'reward' => 'string'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 418);
            };

            $challenge = Challenge::where('id',$id)->where('user_id',$userId)->first();

            if(empty($challenge)){
                return response()->json(["error"=> "challenge not exists"], 404);
            };

            if(isset($request->name)){
                $challenge->name = $request->name;};

            if(isset($request->repeat)){
                $challenge->repeat = $request->repeat;};

            if(isset($request->reward)){
                $challenge->reward = $request->reward;};

            $challenge->save();

            return response()->json(["data"=>$challenge, "success"=>'Challenge updated'], 200);
            
        } catch (\Throwable $th) {
            Log::error('Failed to update the challenge->'.$th->getMessage());
            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }

    public function deleteChallengeById($id)
    {
        try {
            Log::info('delete challenge');
            $userId = auth()->user()->id;

            $challenge = Challenge::where('id',$id)->where('user_id',$userId)->first();

            if(empty($challenge)){
                return response()->json(["error"=> "challenge not exists"], 404);
            };
            $challenge->delete();

            return response()->json(["data"=> "challenge deleted"], 200);

        } catch (\Throwable $th) {
        Log::error('Failes to deleted the challenge->'.$th->getMessage());

        return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }

  
}
