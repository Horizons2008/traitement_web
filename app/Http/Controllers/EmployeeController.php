<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Fonction;
use App\Models\Groupe;
use App\Models\Prime;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    public function getFonctionsByGroupe(Request $request)
    {
        return response()->json(
            Fonction::where('groupe_id', $request->groupe_id)->get()
        );
    }

    public function getPrimesByGroupe(Request $request)
    {
        $primes = Prime::where('groupe_id', $request->groupe_id)
            
            ->get();

        return response()->json($primes);
    }

    // Display list of employees
    public function index()
    {
        $employees = Employee::with(['fonction', 'groupe', 'primes'])
            ->orderBy('nomFr')
            ->orderBy('prenFr')
            ->get();
            
        return view('employees.index', compact('employees'));
    }

    // Show employee creation form
    public function create()
    {
        $fonctions = Fonction::orderBy('title')->get();
        $groupes = Groupe::orderBy('title')->get();
        $primes = Prime::orderBy('title')->get();
        
        return view('employees.create', compact('fonctions', 'groupes', 'primes'));
    }

    // Store new employee with validation and callbacks
    public function store(Request $request)
    {
        // Validate with custom messages and attribute names
        $validated = $this->validateEmployee($request);
        
        // Begin database transaction
        return DB::transaction(function () use ($validated, $request) {
            try {
                // Create employee
                $employee = Employee::create($validated);
                
                // Sync primes if any
                if ($request->has('primes')) {
                    $this->syncPrimes($employee, $request->primes);
                }
                
                // Post-create callback
                $this->afterEmployeeCreated($employee);
                
                return redirect()
                    ->route('employees.index')
                    ->with('success', 'Employee created successfully.');
                    
            } catch (\Exception $e) {
                // Error callback
                $this->onEmployeeCreationError($e);
                
                return back()
                    ->withInput()
                    ->with('error', $this->getUserFriendlyError($e));
            }
        });
    }

    // Show employee edit form
    public function edit(Employee $employee)
    {
        $fonctions = Fonction::orderBy('title')->get();
        $groupes = Groupe::orderBy('title')->get();
        $primes = Prime::orderBy('title')->get();
        
        return view('employees.edit', compact('employee', 'fonctions', 'groupes', 'primes'));
    }

    // Update employee with validation and callbacks
    public function update(Request $request, Employee $employee)
    {
        // Validate with custom messages and attribute names
        $validated = $this->validateEmployee($request, $employee);
        
        // Begin database transaction
        return DB::transaction(function () use ($employee, $validated, $request) {
            try {
                // Update employee
                $employee->update($validated);
                
                // Sync primes if any
                $this->syncPrimes($employee, $request->primes ?? []);
                
                // Post-update callback
                $this->afterEmployeeUpdated($employee);
                
                return redirect()
                    ->route('employees.index')
                    ->with('success', 'Employee updated successfully.');
                    
            } catch (\Exception $e) {
                // Error callback
                $this->onEmployeeUpdateError($e, $employee);
                
                return back()
                    ->withInput()
                    ->with('error', $this->getUserFriendlyError($e));
            }
        });
    }

    // Delete employee
    public function destroy(Employee $employee)
    {dd($employee);
        try {
            // Pre-delete callback
            $this->beforeEmployeeDeleted($employee);
            
            $employee->primes()->detach();
            $employee->delete();
            
            // Post-delete callback
            $this->afterEmployeeDeleted($employee);
            
            return redirect()
                ->route('employees.index')
                ->with('success', 'Employee deleted successfully.');
                
        } catch (\Exception $e) {
            return back()
                ->with('error', $this->getUserFriendlyError($e));
        }
    }

    // Show employee details
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    /***********************
     * PRIVATE METHODS
     ***********************/
    
    /**
     * Validate employee data with custom messages
     */
    private function validateEmployee(Request $request, $employee = null)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
            'string' => 'The :attribute must be text.',
            'max' => 'The :attribute may not be greater than :max characters.',
            'date' => 'The :attribute must be a valid date.',
            'in' => 'The selected :attribute is invalid.',
            'integer' => 'The :attribute must be a number.',
            'min' => 'The :attribute must be at least :min.',
            'boolean' => 'The :attribute field must be true or false.',
            'exists' => 'The selected :attribute does not exist.',
            'primes.array' => 'Please select valid primes.',
            'primes.*.exists' => 'One or more selected primes are invalid.',
            'unique' => 'This :attribute is already in use.',
            'after_or_equal' => 'The :attribute must be after or equal to birth date.',
            'before_or_equal' => 'The :attribute must be before or equal to today.',
        ];

        $attributes = [
            'nomAr' => 'Arabic last name',
            'prenAr' => 'Arabic first name',
            'nomFr' => 'French last name',
            'prenFr' => 'French first name',
            'mobile' => 'mobile number',
            'ddn' => 'birth date',
            'ldn' => 'birth place',
            'sit_famill' => 'family situation',
            'nbrEnfant' => 'number of children',
            'Plus10' => 'number of children',
            'endicape' => 'disabled status',
            'ccp' => 'CCP date',
            'dateRecrut' => 'recruitment date',
            'lastGraduation' => 'last graduation date',
            'cat' => 'category',
            'echelon' => 'echelon',
            'nbrAnneeExperience' => 'years of experience',
            'fonction_id' => 'fonction',
            'groupe_id' => 'groupe',
            'primes' => 'primes',
        ];

        $rules = [
            'nomAr' => 'required|string|max:255',
            'prenAr' => 'required|string|max:255',
            'nomFr' => 'required|string|max:255',
            'prenFr' => 'required|string|max:255',
            'mobile' => 'required|string|max:20|unique:employees,mobile' . 
                        ($employee ? ",{$employee->id}" : ''),
            'ddn' => 'nullable|date|before_or_equal:today',
            'ldn' => 'required|string|max:255',
            'sit_famill' => 'required|integer|in:0,1,2',
            'nbrEnfant' => 'required|integer|min:0',
           
            'endicape' => 'boolean',
            'ccp' => 'required|date|after_or_equal:ddn',
            'dateRecrut' => 'required|date|after_or_equal:ddn',
            'lastGraduation' => 'required|date|after_or_equal:ddn',
            'cat' => 'required|integer|min:1',
            'echelon' => 'required|integer|min:1',
            'nbrAnneeExperience' => 'required|integer|min:0',
            'fonction_id' => 'required|exists:fonctions,id',
            'groupe_id' => 'required|exists:groupes,id',
            'primes' => 'nullable|array',
            'primes.*' => 'exists:primes,id',
        ];

        return $request->validate($rules, $messages, $attributes);
    }

    /**
     * Sync employee primes
     */
    private function syncPrimes($employee, $primes)
    {
        if (is_array($primes)) {
            $employee->primes()->sync($primes);
        }
    }

    /**
     * Convert exceptions to user-friendly messages
     */
    private function getUserFriendlyError(\Exception $e)
    {
        if ($e instanceof \Illuminate\Database\QueryException) {
            return 'A database error occurred. Please try again.';
        }
        
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return 'Please correct the validation errors.';
        }
        
        return 'An error occurred: ' . $e->getMessage();
    }

    /***********************
     * CALLBACK METHODS
     ***********************/
    
    /**
     * Called after successful employee creation
     */
    protected function afterEmployeeCreated(Employee $employee)
    {
        // Example: Log the creation
        activity()
            ->performedOn($employee)
            ->log('Employee created');
            
        // You can add more actions here:
        // - Send notifications
        // - Update related records
        // - Trigger events
    }

    /**
     * Called after successful employee update
     */
    protected function afterEmployeeUpdated(Employee $employee)
    {
        activity()
            ->performedOn($employee)
            ->log('Employee updated');
    }

    /**
     * Called before employee deletion
     */
    protected function beforeEmployeeDeleted(Employee $employee)
    {
        activity()
            ->performedOn($employee)
            ->log('Employee deletion initiated');
    }

    /**
     * Called after successful employee deletion
     */
    protected function afterEmployeeDeleted(Employee $employee)
    {
        activity()
            ->withProperties($employee->toArray())
            ->log('Employee deleted');
    }

    /**
     * Called when employee creation fails
     */
    protected function onEmployeeCreationError(\Exception $e)
    {
        logger()->error('Employee creation failed: ' . $e->getMessage());
    }

    /**
     * Called when employee update fails
     */
    protected function onEmployeeUpdateError(\Exception $e, Employee $employee)
    {
        logger()->error("Employee update failed for ID {$employee->id}: " . $e->getMessage());
    }
}