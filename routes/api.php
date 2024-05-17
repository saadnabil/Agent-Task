<?php

use App\Http\Controllers\Api\User\AgentController;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\FeaturesController;
use App\Http\Controllers\Api\User\RolesController;
use App\Http\Controllers\Api\User\SettingController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;
Route::group(['prefix' => 'v1/user'],function(){
    Route::post('login', [AuthController::class , 'login']);
    Route::post('register', [AuthController::class , 'register']);
    Route::get('countries', [SettingController::class, 'countries']);
    Route::group(['middleware' => 'auth'],function(){
        Route::post('logout', [AuthController::class , 'logout']);
        Route::resource('agent', AgentController::class)->only('index','show','store','update','destroy');
        Route::resource('user', UserController::class)->only('index','show','store','update','destroy');
        Route::get('features/{feature}/approve', [FeaturesController::class, 'approve']);
        Route::resource('features', FeaturesController::class);
        Route::resource('roles', RolesController::class);
    });
});



