<?php

use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\ExpenseController;
use App\Http\Controllers\Api\V1\RecurringController;
use App\Http\Controllers\Api\V1\RevenueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'v1',
], function(){

    Route::post('auth', function(Request $request){
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
    
        if(Auth::attempt($credentials)){
            $user = Auth::user();
    
            $basicToken = $user->createToken('basic-token');
    
            return [
                'token' => $basicToken->plainTextToken,
                'user' => $user
            ];
    
        }
    });

   

});

Route::group([
    'prefix' => 'v1',
    'namespace' => 'App\Http\Controllers\Api\V1',
    'middleware' => 'auth:sanctum'
], function(){
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('expenses', ExpenseController::class);
    Route::apiResource('recurrings', RecurringController::class);
    Route::apiResource('revenues', RevenueController::class);

    Route::get('expenses-by-category', [ExpenseController::class, 'expensesByCategory']);
    Route::get('expenses-by-month', [ExpenseController::class, 'expensesByMonth']);
    Route::get('revenues-by-month', [RevenueController::class, 'revenuesByMonth']);

});
