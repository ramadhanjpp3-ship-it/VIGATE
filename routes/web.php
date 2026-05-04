<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController as UserDashboardController;
use App\Http\Controllers\User\VehicleController as UserVehicleController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\Admin\LogController;
use Illuminate\Support\Facades\Route;

Route::middleware(['prevent-back'])->group(function () {

    Route::middleware(['role:admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class,'dashboard'])
        ->name('dashboard'); // <-- TAMBAH INI

    // Pending Approval - untuk approve/reject kendaraan pending
    Route::get('/pending-approval', [VehicleController::class,'pending']);
    Route::post('/vehicles/{id}/approve', [VehicleController::class,'approve']);
    Route::post('/vehicles/{id}/reject', [VehicleController::class,'reject']);

    // Vehicle Approval - untuk melihat dan menambah kendaraan approved
    Route::get('/vehicles', [VehicleController::class,'index']);
    Route::get('/vehicles/create', [VehicleController::class,'create']);
    Route::post('/vehicles', [VehicleController::class,'store']);
    Route::get('/vehicles/{id}', [VehicleController::class,'show']);
    Route::get('/vehicles/{id}/edit', [VehicleController::class,'edit']);
    Route::put('/vehicles/{id}', [VehicleController::class,'update']);
    Route::delete('/vehicles/{id}', [VehicleController::class,'destroy']);

    Route::get('/logs', [LogController::class,'index']);
    Route::delete('/logs', [LogController::class,'destroyMultiple']);
    Route::get('/logs/{id}', [LogController::class,'show']);

    Route::get('/users', [AdminController::class,'users'])->name('admin.users.index');
    Route::get('/users/create', [AdminController::class,'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class,'storeUser'])->name('admin.users.store');
    Route::get('/users/{user}', [AdminController::class,'showUser'])->name('admin.users.show');
    Route::delete('/users/{user}', [AdminController::class,'destroyUser'])->name('admin.users.destroy');
    Route::get('/gates', [AdminController::class,'gates']);
});

Route::middleware(['role:user'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'dashboard'])
        ->name('user.dashboard');

    Route::get('/vehicles', [UserVehicleController::class, 'index'])
        ->name('user.vehicles.index');
    Route::get('/vehicles/create', [UserVehicleController::class, 'create'])
        ->name('user.vehicles.create');
    Route::post('/vehicles', [UserVehicleController::class, 'store'])
        ->name('user.vehicles.store');
    Route::get('/vehicles/{vehicle}/edit', [UserVehicleController::class, 'edit'])
        ->name('user.vehicles.edit');
    Route::put('/vehicles/{vehicle}', [UserVehicleController::class, 'update'])
        ->name('user.vehicles.update');
    Route::delete('/vehicles/{vehicle}', [UserVehicleController::class, 'destroy'])
        ->name('user.vehicles.destroy');

    Route::get('/history', [UserDashboardController::class, 'history'])
        ->name('user.history');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});

require __DIR__.'/auth.php';

    Route::get('/', function () {
        return view('welcome');
    });
});

// // Route::get('/dashboard', function () {
// //     return view('dashboard');
// // })->middleware(['auth', 'verified'])->name('dashboard');

// // Route::middleware('auth')->group(function () {
// //     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
// //     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
// //     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// // });

// // require __DIR__.'/auth.php';

// // Route::post('/check-access', [NfcController::class, 'check']);
// // Route::post('/upload-image', [NfcController::class, 'upload']);

// // Route::middleware(['auth','role:admin'])->prefix('admin')->group(function () {

// //     Route::get('/dashboard', [AdminController::class, 'dashboard']);

// //     // VEHICLE APPROVAL
// //     Route::get('/vehicles/pending', [AdminController::class, 'pendingVehicles']);
// //     Route::post('/vehicles/{id}/approve', [AdminController::class, 'approveVehicle']);
// //     Route::post('/vehicles/{id}/reject', [AdminController::class, 'rejectVehicle']);

// //     // USERS
// //     Route::get('/users', [AdminController::class, 'users']);

// //     // LOGS
// //     Route::get('/logs', [AdminController::class, 'logs']);
// //     Route::get('/logs/{id}', [AdminController::class, 'logDetail']);

// //     // GATE
// //     Route::get('/gates', [AdminController::class, 'gates']);
// // });


// Route::middleware(['auth'])->group(function () {

//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     });

// });

// // ADMIN
// Route::middleware(['auth','role:admin'])->prefix('admin')->group(function () {
//     Route::get('/dashboard', [AdminController::class,'dashboard']);

//     Route::get('/vehicles/pending', [VehicleController::class,'pending']);
//     Route::post('/vehicles/{id}/approve', [VehicleController::class,'approve']);
//     Route::post('/vehicles/{id}/reject', [VehicleController::class,'reject']);
// });