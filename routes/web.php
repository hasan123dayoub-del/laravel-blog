<?php

// use App\Http\Controllers\UserController;
// use App\Http\Controllers\BlogController;
// use App\Http\Controllers\CategoryController;
// use App\Http\Controllers\AuthController;
// use Illuminate\Support\Facades\Route;
// use Laravel\Fortify\Features;
// use Livewire\Volt\Volt;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::middleware(['auth'])->group(function () {
//     Route::redirect('settings', 'settings/profile');

//     Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
//     Volt::route('settings/password', 'settings.password')->name('user-password.edit');
//     Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

//     Volt::route('settings/two-factor', 'settings.two-factor')
//         ->middleware(
//             when(
//                 Features::canManageTwoFactorAuthentication()
//                     && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
//                 ['password.confirm'],
//                 [],
//             ),
//         )
//         ->name('two-factor.show');
// });

// /*
// |--------------------------------------------------------------------------
// | Frontend Routes
// |--------------------------------------------------------------------------
// */
// Route::get('/', [BlogController::class, 'frontendIndex'])->name('frontend.index');
// Route::get('/blog/{id}', [BlogController::class, 'frontendShow'])->name('frontend.show');
// Route::get('/category/{id}', [BlogController::class, 'frontendByCategory'])->name('frontend.category');

// /*
// |--------------------------------------------------------------------------
// | Authentication Routes
// |--------------------------------------------------------------------------
// */
// Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
// Route::post('/register', [AuthController::class, 'register'])->name('register');
// Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
// Route::post('/login', [AuthController::class, 'login'])->name('login');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// /*
// |--------------------------------------------------------------------------
// | Admin Routes (Bootstrap admin panel)
// |--------------------------------------------------------------------------
// */
// Route::middleware(['auth','CheckUser'])->prefix('admin')->name('admin.')->group(function() {
//     // Redirect /admin => /admin/blogs
//     Route::get('/', function() {
//         return redirect()->route('admin.blogs.index');
//     });

//     /*
//     | Blogs CRUD
//     */
//     Route::resource('blogs', BlogController::class)->except(['show']);
    
//     // Trash, Restore, Force Delete
//     Route::get('blogs/trash', [BlogController::class, 'trash'])->name('blogs.trash');
//     Route::post('blogs/{id}/restore', [BlogController::class, 'restore'])->name('blogs.restore');
//     Route::delete('blogs/{id}/force', [BlogController::class, 'forceDelete'])->name('blogs.forceDelete');

//     /*
//     | Categories CRUD
//     */  Route::get('/', function() {
//         return redirect()->route('admin.categories.index');
//     });
//     Route::resource('categories', CategoryController::class)->except(['show']);
// });

use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Public Home
|--------------------------------------------------------------------------
*/Route::get('/', [BlogController::class, 'frontendIndex'])->name('frontend.index');
Route::get('/blog/{id}', [BlogController::class, 'frontendShow'])->name('frontend.show');
Route::get('/category/{id}', [BlogController::class, 'frontendByCategory'])->name('frontend.category');
Route::middleware('auth')->group(function () {
    Route::get('/favorites', [BlogController::class, 'myFavorites'])->name('frontend.favorites');
Route::post('/toggle-favorite/{id}', [BlogController::class, 'toggleFavorite'])
    ->middleware('auth');

    Route::get('/favorites/remove/{id}', [BlogController::class, 'removeFromFavorites'])->name('frontend.removeFavorite');
});



/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                []
            )
        )
        ->name('two-factor.show');
});

/*
|--------------------------------------------------------------------------
| Admin Panel (Only ADMIN can access)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'CheckUser']) // CheckUser = Admin Only
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Default admin redirect
        Route::get('/', function () {
            return redirect()->route('admin.blogs.index');
        });
        // Route::get('/', function () {
        //     return redirect()->route('admin.categories.index');
        // });

        /*
        | Blogs CRUD
        */
        Route::resource('blogs', BlogController::class)->except(['show']);

        // Trash, Restore, Force Delete
        Route::get('blogs/trash', [BlogController::class, 'trash'])->name('blogs.trash');
        Route::post('blogs/{id}/restore', [BlogController::class, 'restore'])->name('blogs.restore');
        Route::delete('blogs/{id}/force', [BlogController::class, 'forceDelete'])->name('blogs.forceDelete');

        /*
        | Categories CRUD
        */
        Route::resource('categories', CategoryController::class)->except(['show']);
    });
