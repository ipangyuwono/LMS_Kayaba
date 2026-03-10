<?php

use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Customers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\login;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\Logout;
use App\Http\Controllers\Otp;
use App\Http\Controllers\Profile;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuizController;


Route::get('/', function () {
    return view('welcome');
});

//login
Route::get('/login', [login::class, 'index'])->name('login');
Route::post('/login', [login::class, 'dashboardshow']);

//profile
Route::get('/profile', [Profile::class, 'index'])->name('profile')->middleware('otp.verified');
Route::get('/profile/edit', [Profile::class, 'edit'])->name('profile.edit');
Route::put('/profile', [Profile::class, 'update'])->name('profile.update')->middleware('otp.verified');

//otp
Route::get('/otp', [Login::class, 'showOtpForm'])->name('otp.index');
Route::post('/otp', [Login::class, 'verifyOtp'])->name('otp.verify');
Route::post('/otp/resend', [Login::class, 'resendOtp'])->name('otp.resend');

//dashboard
Route::get('/dashboard', [Dashboard::class, 'ecashow'])->name('dashboard')->middleware('otp.verified');

//Logout
Route::post('/logout', [Logout::class, 'logout'])->name('logout');

//Lihat Customer
Route::get('/customers', [Customers::class, 'index'])->name('customers');

//Edit Customer
Route::put('/customers/{customer}', [Customers::class, 'update'])->name('customers.update');

//Tambah Customer
Route::post('/customers', [Customers::class, 'store'])->name('customers.store');

//Delete Customer
Route::delete('/customers/{customer}', [Customers::class, 'delete'])->name('customers.delete');

Route::resource('services', ServiceController::class);

// Order & Payment
Route::get('order/{service}', [OrdersController::class, 'create'])->name('orders.create');
Route::post('order/{service}', [OrdersController::class, 'store'])->name('orders.store');
Route::get('orders', [OrdersController::class, 'index'])->name('orders.index');
Route::get('orders/{order}/check-status', [OrdersController::class, 'checkStatus'])->name('orders.checkStatus');
Route::get('orders/{order}/invoice', [OrdersController::class, 'invoice'])->name('orders.invoice');
Route::get('payment/success', [OrdersController::class, 'success'])->name('orders.success');

// Callback Midtrans (POST, exempt dari CSRF)
Route::post('payment/callback', [OrdersController::class, 'callback'])->name('orders.callback');

// Materi Pelatihan
Route::resource('materials', MaterialController::class)->except(['create', 'show', 'edit']);

// Progress Belajar
Route::get('progress', [ProgressController::class, 'index'])->name('progress.index');
Route::get('progress/{customer}', [ProgressController::class, 'show'])->name('progress.show');
Route::patch('progress/{progress}/status', [ProgressController::class, 'updateStatus'])->name('progress.updateStatus');
Route::post('progress/{customer}/toggle', [ProgressController::class, 'toggle'])->name('progress.toggle');
Route::get('/progress/{customer}/sertifikat', [ProgressController::class, 'certificate'])->name('progress.certificate');

// Quiz
Route::middleware('otp.verified')->group(function () {
Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
Route::get('/quiz/create', [QuizController::class, 'create'])->name('quiz.create');
Route::post('/quiz', [QuizController::class, 'store'])->name('quiz.store');
Route::get('/quiz/{quiz}', [QuizController::class, 'show'])->name('quiz.show');
Route::get('/quiz/{quiz}/edit', [QuizController::class, 'edit'])->name('quiz.edit');
Route::put('/quiz/{quiz}', [QuizController::class, 'update'])->name('quiz.update');
Route::delete('/quiz/{quiz}', [QuizController::class, 'destroy'])->name('quiz.destroy');
Route::post('/quiz/answer/{answer}/grade', [QuizController::class, 'gradeAnswer'])->name('quiz.grade');
Route::get('/quiz/{quiz}/customer/{customer}', [QuizController::class, 'take'])->name('quiz.take');
Route::post('/quiz/{quiz}/customer/{customer}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
Route::get('/quiz/{quiz}/customer/{customer}/result', [QuizController::class, 'result'])->name('quiz.result');
});

//chatbot
Route::post('/chatbot', [ChatbotController::class, 'chat'])->name('chatbot')->middleware('throttle:10,1');

//notifikasi
Route::get('/notifications/poll', [NotificationController::class, 'poll'])->name('notifications.poll');
Route::post('/notifications/read', [NotificationController::class, 'markRead'])->name('notifications.read');
