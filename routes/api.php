<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//AUTH
Route::group([
    'middleware' => ['cors']
], function(){
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
});


Route::group([
    'middleware' => 'jwt.auth'
], function () {
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/profile', [AuthController::class, 'profile']);
});

// USERS

Route::group([
    'middleware' => ['jwt.auth', 'cors']
], function(){
Route::get('/users', [UserController::class, 'getAllUsers']);    

Route::patch('/user/{id}', [UserController::class, 'updateUserById']);   
Route::delete('/user/{id}', [UserController::class, 'deleteUserById']);   
});
Route::get('/user/{id}', [UserController::class, 'getUserById']);  
Route::post('/user', [UserController::class, 'createUser']);  

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
Route::get('/challenge/familyName/{familyName}', [ChallengeController::class, 'getAllChallengeByFamilyName']);    
Route::get('/challenge/{id}', [ChallengeController::class, 'getChallengeById']);  
Route::patch('/challenge/{id}', [ChallengeController::class, 'updateChallengeById']);   
Route::delete('/challenge/{id}', [ChallengeController::class, 'deleteChallengeById']);   
});

//REWARD

Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/reward', [RewardController::class, 'createReward']);  
Route::get('/rewards', [RewardController::class, 'getAllRewards']); 
Route::get('/reward{id}', [RewardController::class, 'getRewardById']); 
Route::patch('/reward/{id}', [RewardController::class, 'updateRewardById']);   
Route::delete('/reward/{id}', [RewardController::class, 'deleteRewardById']);     
});




