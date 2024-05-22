<?php

use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\FilterController;
use App\Http\Controllers\API\LikeController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\ReferralController;
use App\Http\Controllers\API\ReviewController;
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
    Route::any('/register', [CustomerController::class, 'register']);
    Route::post('/details', [CustomerController::class, 'customerDetails'])->middleware('auth:sanctum');
    Route::post('/document', [CustomerController::class, 'document'])->middleware('auth:sanctum');
    Route::post('/wishlist/add', [CustomerController::class, 'addToWishlist'])->middleware('auth:sanctum');
    Route::post('/add-family', [CustomerController::class, 'AddFamily'])->middleware('auth:sanctum');
    Route::post('/update', [CustomerController::class, 'update'])->middleware('auth:sanctum');
    Route::post('/login', [CustomerController::class, 'login']);
    Route::post('/logout', [CustomerController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/reviews', [ReviewController::class, 'store'])->middleware('auth:sanctum');
    Route::post('/feedback', [FeedbackController::class, 'addFeedback'])->middleware('auth:sanctum');
    Route::get('/feedback', [FeedbackController::class, 'GetFeedback'])->middleware('auth:sanctum');
    Route::post('/complaint', [FeedbackController::class, 'addComplaint'])->middleware('auth:sanctum');
    Route::get('/complaint', [FeedbackController::class, 'Getcomplaint'])->middleware('auth:sanctum');
    Route::post('/vendor-time-slots', [SlotController::class, 'getVendorTimeSlots']);
    Route::post('/slots/book', [SlotController::class, 'bookSlot']);
    Route::get('/vendors/filter', [FilterController::class, 'filterVendors'])->middleware('auth:sanctum');
    Route::any('/vendors-all', [CustomerController::class, 'allvendors']);
    Route::post('/specific-vendors-all', [CustomerController::class, 'getVendorById']);
    Route::any('/get-all-posts', [PostController::class, 'allposts']);
});
// Vendor Routes
Route::prefix('vendor')->group(function () {
    Route::post('/register', [VendorController::class, 'register']);
    Route::post('/details', [VendorController::class, 'customerDetails'])->middleware('auth:sanctum');
    Route::post('/update', [VendorController::class, 'update'])->middleware('auth:sanctum');
    Route::post('/details', [VendorController::class, 'vendorDetails'])->middleware('auth:sanctum');
    Route::post('/feedback', [VendorFeedbackController::class, 'addFeedback'])->middleware('auth:sanctum');
    Route::get('/feedback', [VendorFeedbackController::class, 'GetFeedback'])->middleware('auth:sanctum');
    Route::post('/complaint', [VendorFeedbackController::class, 'addcomplaint'])->middleware('auth:sanctum');
    Route::get('/complaint', [VendorFeedbackController::class, 'Getcomplaint'])->middleware('auth:sanctum');
    Route::post('/login', [VendorController::class, 'login']);
    Route::post('/logout', [VendorController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/change-password', [VendorController::class, 'changePassword'])->middleware('auth:sanctum');
    Route::post('/posts', [PostController::class, 'store'])->middleware('auth:sanctum');
    Route::post('/posts/update', [PostController::class, 'update'])->middleware('auth:sanctum');
    Route::post('/blogs/register', [BlogController::class, 'register'])->middleware('auth:sanctum');
    Route::post('/schedule_slots', [SlotController::class, 'scheduleSlot']);
});
Route::prefix('posts')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->middleware('auth:sanctum');
    Route::post('/likes', [LikeController::class, 'store'])->middleware('auth:sanctum');
});

