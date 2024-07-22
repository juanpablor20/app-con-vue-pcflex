<?php

use App\Http\Controllers\Borrower_usersController;
use App\Http\Controllers\DevolucionController;
use App\Http\Controllers\EnvironmentController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\IndexCardController;
use App\Http\Controllers\PanelPrincipalController;
use App\Http\Controllers\PrestamosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\reportsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ServiceController;
use App\Models\Borrower_users;
use App\Models\Programs;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/about', fn () => Inertia::render('About'))->name('about');
    Route::get('/dashboard', [PanelPrincipalController::class, 'index'])->name('dashboard');

//rutas reportes
Route::resource('/repors', reportsController::class);
Route::get('/Repors', [reportsController::class, 'crear'])->name('Repors.crear');
Route::post('/Repors', [reportsController::class, 'creacion'])->name('Repors.creacion');
    //rutas de servicio 
    Route::get('/info/{id}', [ServiceController::class, 'details'])->name('info.details');
    Route::get('historial', [ServiceController::class, 'historico'])->name('historial.historico');
    Route::get('/detalles/{id}', [ServiceController::class, 'show'])->name('detalles.show');
    Route::put('/devolucion', [DevolucionController::class, 'update'])->name('devolucion.resivir');
    Route::get('resivir', [DevolucionController::class, 'resivir'])->name('resivir');
  //  Route::resource('/devolucion', DevolucionController::class);
    Route::resource('/prestamos', PrestamosController::class);
    //ambientes 

    Route::put('/environments/{id}', [EnvironmentController::class, 'update'])->name('environments.update');
Route::put('/environments/activate/{id}', [EnvironmentController::class, 'active'])->name('environments.activate');

    Route::resource('/environments', EnvironmentController::class);
    
//rutas equipos 

    Route::put('/equipments/{id}/reparation', [EquipmentController::class, 'reparation'])->name('equipments.reparation');
    Route::put('/equipments/{id}/activate', [EquipmentController::class, 'active'])->name('equipments.activate');
    Route::resource('/equipments', EquipmentController::class);




//rutas admins 

    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users', [Borrower_users::class, 'update'])->name('users');


//rutas fichas 
    Route::put('indexCard/{id}/activate', [IndexCardController::class, 'active'])->name('indexCard.activate');
    Route::resource('indexCard', IndexCardController::class);

//rutas aprendices 

    Route::put('Borrower_users/{id}/activate', [Borrower_usersController::class, 'activate'])->name('Borrower_users.activate');
    Route::resource('Borrower_users', Borrower_usersController::class);

//rutas programas 
    Route::put('/programs/{id}/activate', [ProgramController::class, 'activate'])->name('programs.activate');
    Route::put('/programs/{id}', [ProgramController::class, 'update'])->name('programs.update');
    Route::resource('programs', ProgramController::class);

//rutas perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
    Route::get('/search_program', [SearchController::class, 'search'])->name('search_program');




    //ruta prestamos

   
});

require __DIR__.'/auth.php';
