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

// Temporary Route for Migration (Delete after use)
Route::get('/migrate', function() {
    try {
        // Debug checks
        $checks = [];
        $checks['App Key'] = config('app.key') ? 'OK' : 'MISSING (Wajib diisi di Vercel!)';
        $checks['DB Config'] = config('database.default');
        $checks['DB Host'] = config('database.connections.pgsql.host') ? 'OK' : 'MISSING (Cek Env Vars)';
        
        if (!config('app.key')) {
            throw new \Exception("APP_KEY belum disetting di Vercel! Copy dari file .env di laptop Anda.");
        }

        \Illuminate\Support\Facades\Artisan::call('migrate:fresh --seed --force');
        
        return response()->json([
            'status' => 'Migration success!',
            'output' => \Illuminate\Support\Facades\Artisan::output(),
            'debug' => $checks
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'debug_info' => $checks ?? 'Checks failed'
        ], 500);
    }
});
