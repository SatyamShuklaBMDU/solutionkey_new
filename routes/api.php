<?php

use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\FeedController;
use App\Http\Controllers\API\FilterController;
use App\Http\Controllers\API\FollowController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ReferralController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\SlotController;
use App\Http\Controllers\API\VendorController;
use App\Http\Controllers\API\VendorFeedbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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
// Customer Routes
Route::prefix('customer')->group(function () {
    Route::any('/sign-up', [CustomerController::class, 'register']);
    Route::post('/details', [CustomerController::class, 'customerDetails'])->middleware('auth:sanctum');
    Route::post('/document', [CustomerController::class, 'document'])->middleware('auth:sanctum');
    Route::post('/wishlist/add', [CustomerController::class, 'addToWishlist'])->middleware('auth:sanctum');
    Route::post('/add-family', [CustomerController::class, 'AddFamily'])->middleware('auth:sanctum');
    Route::post('/update', [CustomerController::class, 'update'])->middleware('auth:sanctum');
    Route::post('/login', [CustomerController::class, 'login']);
    Route::post('/logout', [CustomerController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/reviews', [ReviewController::class, 'store'])->middleware('auth:sanctum');
    Route::post('/put-feedback', [FeedbackController::class, 'addFeedback'])->middleware('auth:sanctum');
    Route::get('/get-feedback', [FeedbackController::class, 'GetFeedback'])->middleware('auth:sanctum');
    Route::post('/complaint', [FeedbackController::class, 'addComplaint'])->middleware('auth:sanctum');
    Route::get('/complaint', [FeedbackController::class, 'Getcomplaint'])->middleware('auth:sanctum');
    Route::post('/vendor-time-slots', [SlotController::class, 'getVendorTimeSlots']);
    Route::post('/slots/book', [SlotController::class, 'bookSlot']);
    Route::get('/vendors/filter', [FilterController::class, 'filterVendors'])->middleware('auth:sanctum');
    Route::any('/vendors-all', [CustomerController::class, 'allvendors']);
    Route::post('/specific-vendors-all', [CustomerController::class, 'getVendorById']);
    Route::any('/get-all-posts', [PostController::class, 'allposts']);
    Route::get('home-banner',[BannerController::class,'index'])->middleware('auth:sanctum');
    Route::get('/get-category',[ServiceController::class,'index'])->middleware('auth:sanctum');
    Route::get('/get-notification',[NotificationController::class,'index']);
    Route::post('follow',[FollowController::class,'follow'])->middleware('auth:sanctum');
    Route::post('Unfollow',[FollowController::class,'unfollow'])->middleware('auth:sanctum');
    Route::get('feed',[FeedController::class,'index'])->middleware('auth:sanctum');
    Route::get('notifications',[NotificationController::class,'sendNotify'])->middleware('auth:sanctum');
});
Route::prefix('posts')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->middleware('auth:sanctum');
    Route::post('/likes', [LikeController::class, 'store'])->middleware('auth:sanctum');
});