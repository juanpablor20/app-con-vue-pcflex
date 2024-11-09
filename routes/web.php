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
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        //'canRegister' => Route::has('register'),
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
Route::resource('/repors', reportsController::class) ->middleware('can:gestionar.recursos');
Route::get('/Repors', [reportsController::class, 'crear'])->name('Repors.crear') ->middleware('can:gestionar.recursos');
Route::post('/Repors', [reportsController::class, 'creacion'])->name('Repors.creacion') ->middleware('can:gestionar.recursos');
    //rutas de servicio 
    Route::get('/info/{id}', [ServiceController::class, 'details'])->name('info.details');
    Route::get('historial', [ServiceController::class, 'historico'])->name('historial.historico');
    Route::get('/detalles/{id}', [ServiceController::class, 'show'])->name('detalles.show');
    Route::put('/devolucion', [DevolucionController::class, 'update'])->name('devolucion.resivir') ->middleware('can:gestionar.recursos');
    Route::get('resivir', [DevolucionController::class, 'resivir'])->name('resivir') ->middleware('can:gestionar.recursos');
  //  Route::resource('/devolucion', DevolucionController::class);
    Route::resource('/prestamos', PrestamosController::class) ->middleware('can:gestionar.recursos');
    //ambientes 

    Route::put('/environments/{id}', [EnvironmentController::class, 'update'])->name('environments.update') ->middleware('can:gestionar.recursos');
Route::put('/environments/activate/{id}', [EnvironmentController::class, 'active'])->name('environments.activate') ->middleware('can:gestionar.recursos');

    Route::resource('/environments', EnvironmentController::class) ->middleware('can:gestionar.recursos');
    
//rutas equipos 

    Route::put('/equipments/{id}/reparation', [EquipmentController::class, 'reparation'])->name('equipments.reparation') ->middleware('can:gestionar.recursos');
    Route::put('/equipments/{id}/activate', [EquipmentController::class, 'active'])->name('equipments.activate') ->middleware('can:gestionar.recursos');
    Route::resource('/equipments', EquipmentController::class)->middleware('can:gestionar.recursos');


   

//rutas admins 
 Route::resource('/users', UserController::class)->middleware('can:crud.bibliotecario');
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    
   // Route::post('/users', [Borrower_users::class, 'update'])->name('users.update');


//rutas fichas 
    Route::put('indexCard/{id}/activate', [IndexCardController::class, 'active'])->name('indexCard.activate') ->middleware('can:gestionar.recursos');
    Route::resource('indexCard', IndexCardController::class) ->middleware('can:gestionar.recursos');

//rutas aprendices 

    Route::put('Borrower_users/{id}/activate', [Borrower_usersController::class, 'activate'])->name('Borrower_users.activate')->middleware('can:gestionar.recursos');
    Route::resource('Borrower_users', Borrower_usersController::class) ->middleware('can:gestionar.recursos');

//rutas programas 
    Route::put('/programs/{id}/activate', [ProgramController::class, 'activate'])->name('programs.activate') ->middleware('can:gestionar.recursos');
    Route::put('/programs/{id}', [ProgramController::class, 'update'])->name('programs.update') ->middleware('can:gestionar.recursos');
    Route::resource('programs', ProgramController::class) ->middleware('can:gestionar.recursos');

//rutas perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
    Route::get('/search_program', [SearchController::class, 'search'])->name('search_program');


//rutas pdf

    Route::get('/pdfequipos', [EquipmentController::class, 'pdfequipos'])->name('pdfequipos');
    Route::get('/pdfUsuarios', [Borrower_usersController::class, 'pdfUsuarios'])->name('pdfUsuarios');
    //ruta prestamos

   
});

require __DIR__.'/auth.php';
