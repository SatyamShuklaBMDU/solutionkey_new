<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RewardCommissionController;
use App\Http\Controllers\ServiceController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    Auth::logout();
    // session()->invalidate();
    return view('auth.login');
});

Route::get('/mi',function(){
    Artisan::call('migrate --path=database/migrations/2024_04_12_065256_create_slot_scheduling_partners_table.php');
    return 'done';
});

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('optimize:clear');
    return 'DONE'; //Return anything
});
Route::get('/generate-key', function () {
    Artisan::call('key:generate');
    return 'Application key generated successfully';
});
Route::get('/session-table', function () {
    Artisan::call('session:table');
    return 'Session successfully';
});
Route::get('/migrate', function () {
    Artisan::call('migrate');
    return 'Migrated';
});
Route::get('/run-composer-command', function () {
    $output = shell_exec('composer dump-autoload');
    return '<pre>' . $output . '</pre>';
});
Route::get('/dashboard', function () {
    return view('layout.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/change-vendor-account-status', [VendorController::class,'changeAccountStatus'])->name('change.vendor.account.status');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::middleware(['auth', 'permission:usermanagement'])->group(function () {
        Route::get('/add-user', [UserController::class, 'adduser'])->name('add-users');
        Route::post('/edit-users', [UserController::class, 'editUser'])->name('edituserlist');
        Route::post('/update-users', [UserController::class, 'updateUser'])->name('updateuserlist');
        Route::get('/all-user', [UserController::class, 'alluser'])->name('all-users');
        Route::post('/user/filter',[UserController::class,'filter'])->name('user-filter');
        Route::post('/user-store', [UserController::class, 'user_store'])->name('users-store');
        Route::delete('/delete-user/{id}', [UserController::class, 'destroy'])->name('delete-user');

    });
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::middleware(['auth','permission:customermanagement'])->group(function () {
        // Route::group(['Middleware'=>'web'],function(){
        Route::get('/customer/show',[CustomerController::class,'show'])->name('customer-shows');
        Route::post('/change-customer-status', [CustomerController::class,'changeAccountStatus'])->name('change.account.status');
        Route::post('/customer/filter/show',[CustomerController::class,'filter'])->name('customer-filters');
        Route::delete('/delete-customer/{id}', [CustomerController::class, 'destroy'])->name('delete-customer');
    });
    Route::middleware(['permission:professionalmanagement'])->group(function () {
        Route::get('/vendor/show',[VendorController::class,'show'])->name('vendor-show');
        Route::post('/vendor/filter',[VendorController::class,'filter'])->name('vendor-filter');
    });
    // FeedBack Route
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback');
    Route::post('/feedback/filter',[FeedbackController::class,'filter'])->name('feedback-filter');
    Route::delete('/delete-feedback/{id}', [FeedbackController::class, 'destroy'])->name('delete-feedback');
    // Complaint Route
    Route::get('/complaint', [ComplaintController::class, 'index'])->name('complaint');
    Route::post('/complaint/filter',[ComplaintController::class,'filter'])->name('complaint-filter');
    Route::delete('/delete-complaint/{id}', [ComplaintController::class, 'destroy'])->name('delete-complaint');
    //Service Route
    Route::get('/service', [ServiceController::class, 'index'])->name('service');
    Route::post('/services/filter',[ServiceController::class,'filter'])->name('service-filter');
    Route::get('/service-create', [ServiceController::class, 'create'])->name('service-create');
    Route::post('/services', [ServiceController::class, 'service_store'])->name('services-store'); 
    Route::get('/services-edit/{service}', [ServiceController::class, 'edit'])->name('services-edit');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services-update');
    Route::delete('/delete-service/{id}', [ServiceController::class, 'destroy'])->name('delete-service');
    //Blog Controller
    Route::get('/blog/Pending', [BlogController::class, 'pending'])->name('blog-pending');
    Route::post('/change-account-status', [BlogController::class,'changeAccountStatus'])->name('change.blog.status');
    Route::post('/blog-penidng/filter',[BlogController::class,'Pendingfilter'])->name('blog-pending-filter');
    Route::post('/blog-approve/filter',[BlogController::class,'Approvefilter'])->name('blog-approve-filter');
    Route::get('/blog/Approved', [BlogController::class, 'approved'])->name('blog-approved');
    //Notifactions Route
    Route::get('/notification', [NotificationController::class, 'index'])->name('notification');
    Route::get('/notification/create', [NotificationController::class, 'create'])->name('notification-create');
    Route::post('/notification/filter', [NotificationController::class, 'filter'])->name('notification-filter');
    Route::post('/notification/store', [NotificationController::class, 'store'])->name('notification-store');
    Route::delete('/delete-notification/{id}', [NotificationController::class, 'destroy'])->name('notification.destroy');
    // Document Route
    Route::get('/customer/Documents', [DocumentController::class, 'index'])->name('customer-document');
    Route::post('/document/filter', [DocumentController::class, 'filter'])->name('document-filter');
    // Family Route
    Route::get('/customer/Family', [FamilyController::class, 'index'])->name('customer-family');
    Route::post('/fimily/filter', [FamilyController::class, 'filter'])->name('family-filter');
    //Booking Controller 
    Route::get('/online/booking', [BookingController::class, 'online_booking'])->name('online-booking');
    Route::post('/online/filter', [BookingController::class, 'online_filter'])->name('online-filter');
    Route::get('/physical/booking', [BookingController::class, 'physical_booking'])->name('physical-booking');
    Route::post('/physical/filter', [BookingController::class, 'physical_filter'])->name('physical-filter');
    //Referral Controller
    Route::get('/Referral/Earning', [ReferralController::class, 'index'])->name('referral-earning');
    Route::post('/Referral/filter', [ReferralController::class, 'filter'])->name('referral-filter');
    // Controller
    Route::get('/review/Rating', [ReviewController::class, 'index'])->name('reviews-rating');
    Route::post('/review/filter', [ReviewController::class, 'filter'])->name('review-filter');
    //Reward And Commission Route
    Route::get('/reward/commission', [RewardCommissionController::class, 'index'])->name('reward-commission');
    Route::get('/reward/commission/create', [RewardCommissionController::class, 'create'])->name('reward-create');
    Route::post('/reward/commission/store', [RewardCommissionController::class, 'store'])->name('reward-store');
    Route::get('/reward/commission/edit/{reward}', [RewardCommissionController::class, 'edit'])->name('reward-edit');
    Route::put('/reward/commission/{service}', [RewardCommissionController::class, 'update'])->name('reward-update');
    Route::post('/reward/filter', [RewardCommissionController::class, 'filter'])->name('reward-filter');
    Route::get('/delete-reward/{id}', [RewardCommissionController::class, 'destroy'])->name('delete-reward');
});

require __DIR__.'/auth.php';
