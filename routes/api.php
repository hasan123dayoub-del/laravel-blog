<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\BlogController;
// use App\Http\Controllers\CategoryController;
// use App\Http\Controllers\UserController;


// Route::prefix('blogs')->group(function () {

//     Route::get('/', [BlogController::class, 'index']);                // جميع البلوقات
//     Route::post('/', [BlogController::class, 'store']);               // إنشاء
//     Route::get('/trash', [BlogController::class, 'trash']);           // البلوقات المحذوفة
//     Route::get('/{id}', [BlogController::class, 'show']);             // عرض واحد
//     Route::post('/{id}/update', [BlogController::class, 'update']);   // تعديل
//     Route::delete('/{id}', [BlogController::class, 'softDelete']);    // Soft delete
//     Route::post('/{id}/restore', [BlogController::class, 'restore']); // استعادة
//     Route::delete('/{id}/force', [BlogController::class, 'forceDelete']); // حذف نهائي
// });

// Route::prefix('categories')->group(function () {
//     Route::get('/', [CategoryController::class, 'index']);
//     Route::post('/', [CategoryController::class, 'store']);
//     Route::get('/{id}', [CategoryController::class, 'show']);
//     Route::post('/{id}/update', [CategoryController::class, 'update']);
//     Route::delete('/{id}', [CategoryController::class, 'destroy']);
// });




// Route::post('/register', [UserController::class, 'register']);
// Route::post('/login', [UserController::class, 'login']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [UserController::class, 'logout']);
// });
