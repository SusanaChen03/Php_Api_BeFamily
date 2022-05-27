<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\MemberController;
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
Route::post('/reward', [ChallengeController::class, 'createReward']);  
Route::get('/rewards', [ChallengeController::class, 'getAllReward']);    
Route::get('/reward/{id}', [ChallengeController::class, 'getRewardById']);  //buscar por id de challenge
Route::patch('/reward/{id}', [ChallengeController::class, 'updateRewardById']);   
Route::delete('/reward/{id}', [ChallengeController::class, 'deleteRewardById']);   
});



