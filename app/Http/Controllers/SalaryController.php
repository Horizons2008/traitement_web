<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Groupe;
use App\Models\Prime;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function calculate(Employee $employee)
    {
        $salaryData = Salary::calculateForEmployee($employee);
        
        // Check if salary exists for this month
        $existingSalary = Salary::where('employee_id', $employee->id)
            ->whereMonth('created_at', now()->month)
            ->first();

        if ($existingSalary) {
            $existingSalary->update($salaryData);
            return redirect()->route('salaries.show', $existingSalary->id)
                ->with('success', 'Salary updated successfully');
        }

        $salary = Salary::create($salaryData);
        return redirect()->route('salaries.show', $salary->id)
            ->with('success', 'Salary calculated successfully');
    }
    // app/Http/Controllers/SalaryController.php

    public function calculateAll(Request $request)
{
   
    
    // Get all primes first to maintain consistent order
    $allPrimes = Prime::with('configurations')->get();
    
    $employees = Employee::with(['primes.configurations'])->where('groupe_id', $request->groupe_id)->get();
    $results = [];
    
    foreach ($employees as $employee) {
        $salaryData = Salary::calculateForEmployee($employee, $request->groupe_id);
        
        Salary::updateOrCreate(
            ['employee_id' => $employee->id, 'created_at' => now()->startOfMonth()],
            $salaryData
        );
        
        $results[] = [
            'employee' => $employee,
            'salary' => $salaryData
        ];
    }
    $groupes = Groupe::all();
       // return view('primes.create', compact('groupes'));
    
    return view('salaries.index', [
        'results' => $results,
        'month' => now()->format('F Y'),
        'allPrimes' => $allPrimes ,'groupes' => Groupe::all(),
        'groupe_id' => $request->groupe_id
        // Pass all primes to view
    ]);
}

    public function show(Salary $salary)
    {
        $salary->load('employee');
        return view('salaries.show', compact('salary'));
    }

    public function index()
    {
        $salaries = Salary::with('employee')->latest()->get();
        return view('salaries.index', compact('salaries'));
    }
}