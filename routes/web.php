<?php
namespace App\Http\Controllers;

use App\Http\Controllers\RegisterController;
use App\Models\Groupe;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Redirect root to dashboard if authenticated, otherwise to login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        // You would typically fetch these counts from your database
        return view('dashboard', [
            'employeeCount' => \App\Models\Employee::count(),
            'positionCount' => \App\Models\Fonction::count(),
            'bonusCount' => \App\Models\Prime::count(),
            'salaryCount' => \App\Models\Employee::count(),
        ]);
    })->name('dashboard');

    Route::resource('fonctions', FonctionController::class);
    Route::resource('groupes', GroupeController::class);
    Route::resource('points', PointController::class);
    Route::resource('primes', PrimeController::class);
    Route::resource('employees', EmployeeController::class);
    
    // Prime Configurations routes
    Route::get('primes/{prime}/configurations', [PrimeConfigurationController::class, 'index'])->name('primes.configurations.index');
    Route::get('primes/{prime}/configurations/create', [PrimeConfigurationController::class, 'create'])->name('primes.configurations.create');
    Route::post('primes/{prime}/configurations', [PrimeConfigurationController::class, 'store'])->name('primes.configurations.store');
    Route::get('primes/{prime}/configurations/{configuration}/edit', [PrimeConfigurationController::class, 'edit'])->name('primes.configurations.edit');
    Route::put('primes/{prime}/configurations/{configuration}', [PrimeConfigurationController::class, 'update'])->name('primes.configurations.update');
    Route::delete('primes/{prime}/configurations/{configuration}', [PrimeConfigurationController::class, 'destroy'])->name('primes.configurations.destroy');

    Route::get('employees/{employee}/calculate-salary', [SalaryController::class, 'calculate'])
        ->name('employees.calculate-salary');
    Route::post('calculate-all', [SalaryController::class, 'calculateAll'])
        ->name('calculate-all');

    Route::get('/fonctions-by-groupe', [EmployeeController::class, 'getFonctionsByGroupe'])
        ->name('fonctions-by-groupe');
    Route::get('/primes-by-groupe', [EmployeeController::class, 'getPrimesByGroupe'])
        ->name('primes-by-groupe');
});

// Language Switch Route
Route::get('language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) {
        session()->put('locale', $locale);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('language.switch');
