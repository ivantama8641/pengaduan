<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\AuthController;
use App\Models\Complaint;
use Illuminate\Support\Facades\Route;

Route::get('/', [ComplaintController::class, 'index'])->name('home');
Route::post('/complaints', [ComplaintController::class, 'store'])->name('complaints.store');
Route::get('/complaints/success/{ticket_id}', [ComplaintController::class, 'success'])->name('complaints.success');
Route::match(['get', 'post'], '/track', [ComplaintController::class, 'track'])->name('complaints.track');
Route::get('/complaint/{ticket_id}', [ComplaintController::class, 'show'])->name('complaints.show');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $stats = [
            'total' => Complaint::count(),
            'pending' => Complaint::where('status', 'pending')->count(),
            'process' => Complaint::where('status', 'process')->count(),
            'done' => Complaint::where('status', 'done')->count(),
        ];
        $complaints = Complaint::with(['category', 'user'])->latest()->paginate(10);
        return view('dashboard', compact('stats', 'complaints'));
    })->name('dashboard');

    Route::post('/complaints/{ticket_id}/status', [ComplaintController::class, 'updateStatus'])->name('complaints.status');
    Route::post('/complaints/{ticket_id}/reply', [ComplaintController::class, 'storeResponse'])->name('complaints.reply');
});
