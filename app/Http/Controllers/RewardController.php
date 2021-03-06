<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
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
                'image' => 'required|url',
                'description' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 418);
            };

            $newReward = new Reward();
            $userId = auth()->user()->id;
            $newReward->name = $request->name;
            $newReward->color = $request->color;
            $newReward->image = $request->image;
            $newReward->description = $request->description;
            $newReward->familyName = $request->familyName;
            $newReward->save();

            return response()->json(["data" => $newReward, "success" => true], 200);
        } catch (\Throwable $th) {
            Log::error('Failed to create the Reward->' . $th->getMessage());

            return response()->json(['error' => 'Ups! Something wrong',  "success" => false], 500);
        }
    }

    public function getAllRewards()
    {
        try {
            Log::info('Get all rewards');

            $reward = Reward::all();

            if (empty($reward)) {
                return response()->json(
                    ["success" => "There are not rewards"],
                    202
                );
            };
            return response()->json($reward, 200);
        } catch (\Throwable $th) {
            Log::error('Failed to get all reward->' . $th->getMessage());

            return response()->json(['error' => 'Ups! Something wrong'], 500);
        }
    }

    public function getRewardByFamilyName($familyName)
    {

        try {
            Log::info('Get rewards by familyNAme');

            $reward = DB::table('rewards')->where('familyName', $familyName)->get();

            if (empty($reward)) {
                return response()->json(
                    ["success" => "There are not reward"],
                    202
                );
            };

            return response()->json($reward, 200);
        } catch (\Throwable $th) {
            Log::error('Failed to get the members->' . $th->getMessage());

            return response()->json(['success' => false . $th], 500);
        }
    }
    public function getRewardByIds($id)
    {

        try {
            Log::info('Get rewards by id');

            $reward = DB::table('rewards')->where('id', $id)->first();

            if (empty($reward)) {
                return response()->json(
                    ["success" => false],
                    202
                );
            };

            return response()->json($reward, 200);
        } catch (\Throwable $th) {
            Log::error('Failed to get the members->' . $th->getMessage());

            return response()->json(['success' => false], 500);
        }
    }
    public function updateRewardById(Request $request, $id)
    {
        try {
            Log::info('init update reward by id');

            $validator = Validator::make($request->all(), [
                'name' => 'string|max:250',
                'image' => 'url',
                'description' => 'string|max:500'
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 418);
            };

            $reward = Reward::where('id', $id)->first();

            if (empty($reward)) {
                return response()->json(['success' => false], 404);
            };
            if (isset($request->name)) {
                $reward->name = $request->name;
            };
            if (isset($request->image)) {
                $reward->image = $request->image;
            };
            if (isset($request->description)) {
                $reward->description = $request->description;
            };

            $reward->save();
            return response()->json(["data" => $reward, "success" => true], 200);
        } catch (\Throwable $th) {
            Log::error('Failed to update the reward->' . $th->getMessage());
            return response()->json(['success' => false], 500);
        };
    }

    public function deleteRewardById($id)
    {
        try {
            Log::info('init delete reward');

            $reward = Reward::where('id', $id)->first();

            if (empty($reward)) {
                return response()->json(['error' => 'Not found the reward'], 404);
            }

            $reward->delete();
            return response()->json(["data" => "reward deleted"], 200);
        } catch (\Throwable $th) {
            Log::error('Failed to delete the Reward');
        }
    }
}
