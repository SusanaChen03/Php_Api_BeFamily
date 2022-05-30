<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Reward;

class RewardController extends Controller
{
    
    public function createReward(Request $request)
    {
        try {
            Log::info('Init create reward');
            $validator = Validator::make($request->all(), [   
                'name' => 'required|string',
                'image'=>'required|url',
                'description'=>'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 418);
            };

            $newReward= new Reward();
            $userId = auth()->user()->id;
            $newReward->name = $request->name;
            $newReward->image = $request->image;
            $newReward->description = $request->description;
            $newReward->challenge_id= $request->challenge_id;
           

            $newReward->save();

            return response()->json(["data"=>$newReward, "success"=>'Reward created'], 200);
     
        } catch (\Throwable $th) {
            Log::error('Failed to create the Reward->'.$th->getMessage());

            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }

    
    public function getAllReward($challenge_id) //get all rewards for challenge id
    {
        try {
            Log::info('start get all rewards');

            $reward = DB::table('rewards')->where('challenge_id', $challenge_id)->get()->toArray();

            if (empty($reward)) {
                return response()->json(["success"=> "There are not rewards"], 202);
            };

            return response()->json($reward, 200);

        } catch (\Throwable $th) {
            Log::error('Failed to get all rewards->'.$th->getMessage());
            return response()->json(['error'=> 'Ups! Something Wrong'], 500);
        }
    }

    
    public function updateRewardById(Request $request, $id)
    {
        try {
            Log::info('init update reward by id');

            $validator = Validator::make($request->all(), [
                'name' => 'string|max:250',
                'image' => 'url',
                'description'=> 'string|max:500'
            ]); 
            if ($validator->fails()) {
                return response()->json($validator->errors(), 418);
            };

            $reward = Reward::where('id', $id)->first();

            if(empty($reward)){
                return response()->json(['error'=>'rewards not exist'],404);
            };
            if(isset($request->name)){
                $reward->name = $request->name;
            };
            if(isset($request->image)){
                $reward->image = $request->image;
            };
            if(isset($request->description)){
                $reward->description = $request->description;
            };

            $reward->save();
            return response()->json(["data"=>$reward, "success"=>'Reward updated'], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to update the reward->'.$th->getMessage());
            return response()->json(['error'=> 'Ups! Something Wrong'], 500);
        };
    }

    public function deleteRewardById($id)
    {
        try {
            Log::info('init delete reward');

            $reward = Reward::where('id',$id)->first();

            if(empty($reward)){
                return response()->json(['error'=>'Not found the reward'], 404);
            }

            $reward->delete();
            return response()->json(["data"=> "reward deleted"], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to delete the Reward');
        }
    }

}