<?php

namespace App\Http\Controllers;

use App\Models\Employee;
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

    public function calculateAll()
    {
        $employees = Employee::with(['primes.configurations'])->get();
        $results = [];
        
        foreach ($employees as $employee) {
            $salaryData = Salary::calculateForEmployee($employee);
            
            $salary = Salary::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'created_at' => now()->startOfMonth()
                ],
                $salaryData
            );
            
            $results[] = [
                'employee' => $employee,
                'salary' => $salaryData,
                'prime_details' => $salaryData->prime_details
            ];
        }
        
        return view('salaries.bulk-results', [
            'results' => $results,
            'month' => now()->format('F Y')
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