<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//AUTH

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'jwt.auth'
], function () {
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/profile', [AuthController::class, 'profile']);
});

// USERS

Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/user', [UserController::class, 'createUser']);  
Route::get('/users', [UserController::class, 'getAllUsers']);    
Route::get('/user/{id}', [UserController::class, 'getUserById']);  
Route::patch('/user/{id}', [UserController::class, 'updateUserById']);   
Route::delete('/user/{id}', [UserController::class, 'deleteUserById']);   
});


//MEMBER

Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/member', [MemberController::class, 'createUserMember']);  
});

//CHALLENGE

Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/challenge', [ChallengeController::class, 'createChallenge']);  
Route::get('/challenges', [ChallengeController::class, 'getAllChallenges']);    
Route::get('/challenge/{id}', [ChallengeController::class, 'getChallengeById']);  
Route::patch('/challenge/{id}', [ChallengeController::class, 'updateChallengeById']);   
Route::delete('/challenge/{id}', [ChallengeController::class, 'deleteChallengeById']);   
});

//REWARD

Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/reward', [RewardController::class, 'createReward']);  
Route::get('/rewards/{challenge_id}', [RewardController::class, 'getAllReward']); 
Route::patch('/reward/{id}', [RewardController::class, 'updateRewardById']);   
Route::delete('/reward/{id}', [RewardController::class, 'deleteRewardById']);   
});


//buscar por id de challenge


Route::get('/reward/{id}', [RewardController::class, 'getRewardById']);   // find by user_id 

// public function getRewardById($id) ////funciona igual que el de arriba 
// {
//     try {
//         Log::info('init get reward by id');
//         $userId = auth()->user()->id;

//         $reward = DB::table('rewards')->where('user_id', $userId)->where('user_id', $id)->get();

//         if(empty($reward)){
//             return response()->json(['These not have rewards'], 404);
//         };
//         return response()->json($reward, 200);

//     } catch (\Throwable $th) {
//         Log::error('Failed to get reward by Id');
//         return response()->json(['error'=> 'Ups! Somethings wrong'], 500);
//     }
// }