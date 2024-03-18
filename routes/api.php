<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// 인증 관련 Routes
Route::middleware('auth:api')->group(function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
});

// 유저 관련 Routes
Route::middleware('auth:api')->group(function() {
    Route::put('user/me', [UserController::class, 'updateAdditionalInfo']);
    Route::put('user/me/type', [UserController::class, 'updateUserType']);
});

// 질문 관련 Routes
Route::middleware('auth:api')->group(function() {
    Route::post('question', [QuestionController::class, 'createQuestion']);
    Route::delete('question/{id}', [QuestionController::class, 'deleteQuestion']);
    Route::post('question/{id}/answer', [QuestionController::class, 'answerQuestion']);
    Route::put('question/{question_id}/answer/{answer_id}/choose', [QuestionController::class, 'chooseAnswer']);
    Route::delete('question/{question_id}/answer/{answer_id}', [QuestionController::class, 'deleteAnswer']);
});
Route::get('question', [QuestionController::class, 'getQuestionList']);
Route::get('question/{id}', [QuestionController::class, 'getQuestion']);