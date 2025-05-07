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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);


Route::resource('fonctions', FonctionController::class)->middleware('auth');

Route::resource('groupes', GroupeController::class)->middleware('auth');
Route::resource('points', PointController::class)->middleware('auth');
Route::resource('primes', PrimeController::class)->middleware('auth');
Route::resource('employees', EmployeeController::class);
Route::resource('configurations', PrimeConfigurationController::class)
    ->shallow()
    ->except(['show','edit','delete']);
    Route::get('primes/{prime}/configurations', [PrimeConfigurationController::class, 'index'])
    ->name('primes.configurations.index')
    ->middleware('auth');
    //Route::get('primes/{prime}/configurations', [PrimeConfigurationController::class, 'delete'])
    //->name('primes.configurations.delete')
    //->middleware('auth');

    Route::get('employees/{employee}/calculate-salary', [SalaryController::class, 'calculate'])
    ->name('employees.calculate-salary');
    Route::post('calculate-all', [SalaryController::class, 'calculateAll'])
        ->name('calculate-all');

        


      
Route::get('/fonctions-by-groupe', [EmployeeController::class, 'getFonctionsByGroupe'])->name('fonctions-by-groupe');
Route::get('/primes-by-groupe', [EmployeeController::class, 'getPrimesByGroupe'])->name('primes-by-groupe');

Route::get('/dashboard', function () {
    // You would typically fetch these counts from your database
    return view('dashboard', [
        'employeeCount' =>  5,//\App\Models\Employee::count(),
        'positionCount' => 48,//\App\Models\Position::count(),
        'bonusCount' => 20,//\App\Models\Bonus::count(),
        'salaryCount' => 30,//\App\Models\Salary::count(),
    ]);
})->middleware(['auth'])->name('dashboard');
