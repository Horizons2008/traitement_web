<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'point_cat',
        'mont_cat',
        'point_echelon',
        'mont_echelon',
        'sal_base',
        'prime_details',
        'total_primes',
        'sal_brut',
        'assurance',
        'net_salary'
    ];

    protected $casts = [
        'prime_details' => 'array'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public static function calculateForEmployee(Employee $employee,$groupeId)
    {
        // Get all primes from the system
        $allPrimes = Prime::with('configurations')->where('groupe_id', $groupeId)->get();
        
        // Existing base salary calculation
        $pointCat = Point::where('cat', $employee->cat)
                       ->where('echelon', 0)
                       ->value('valeur') ?? 0;
        $montCat = $pointCat * 45;
        $groupeId==1? $pointEchelon=20 : $pointEchelon=10;
        
       /* $pointEchelon = Point::where('cat', $employee->cat)
                           ->where('echelon', $employee->echelon)
                           ->value('valeur') ?? 0;*/
        $montEchelon = $pointEchelon * 45;
        
        $salBase = $montCat + $montEchelon;
    
        // Calculate primes for all system primes
        $primeDetails = [];
        $totalPrimes = 0;
    
        foreach ($allPrimes as $prime) {
            $configuration = $prime->configurations()
                ->where(function($query) use ($employee) {
                    $query->where('min_cat', '<=', $employee->cat)
                          ->orWhereNull('min_cat');
                })
                ->where(function($query) use ($employee) {
                    $query->where('max_cat', '>=', $employee->cat)
                          ->orWhereNull('max_cat');
                })
                ->first();
    
            $montPrime = 0;
            $calculation = 'Not applicable';
            $applied = false;
    
            if ($configuration) {
                $prime->mode== 0 ?  $montPrime = $configuration->valeur * 0.01 * $salBase : ($configuration->mode == 1 ?  $montPrime = $configuration->valeur *45 :  $montPrime = $configuration->valeur );
                $montPrime = $configuration->valeur * 0.01 * $salBase;
                $calculation = "{$configuration->valeur}% of " . number_format($salBase, 2);
                $totalPrimes += $montPrime;
                $applied = true;
            }
    
            $primeDetails[] = [
                'prime_id' => $prime->id,
                'prime_title' => $prime->title,
                'min_cat' => $configuration->min_cat ?? 'N/A',
                'max_cat' => $configuration->max_cat ?? 'N/A',
                'percentage' => $configuration->valeur ?? 0,
                'calculation' => $calculation,
                'mont_prime' => $montPrime,
                'applied' => $applied
            ];
        }
    
        // Rest of salary calculations
        $salBrut = $salBase + $totalPrimes;
        $assurance = $salBrut * 0.09;
        $netSalary = $salBrut - $assurance;
    
        return [
            'employee_id' => $employee->id,
            'point_cat' => $pointCat,
            'mont_cat' => $montCat,
            'point_echelon' => $pointEchelon,
            'mont_echelon' => $montEchelon,
            'sal_base' => $salBase,
            'prime_details' => $primeDetails,
            'total_primes' => $totalPrimes,
            'sal_brut' => $salBrut,
            'assurance' => $assurance,
            'net_salary' => $netSalary
        ];
    }
    // Accessors for formatted values
    public function getFormattedMontCatAttribute()
    {
        return number_format($this->mont_cat, 2);
    }

    public function getFormattedMontEchelonAttribute()
    {
        return number_format($this->mont_echelon, 2);
    }

    public function getFormattedSalBaseAttribute()
    {
        return number_format($this->sal_base, 2);
    }

    public function getFormattedTotalPrimesAttribute()
    {
        return number_format($this->total_primes, 2);
    }

    public function getFormattedSalBrutAttribute()
    {
        return number_format($this->sal_brut, 2);
    }

    public function getFormattedAssuranceAttribute()
    {
        return number_format($this->assurance, 2);
    }

    public function getFormattedNetSalaryAttribute()
    {
        return number_format($this->net_salary, 2);
    }

    public function getPrimeDetailsListAttribute()
    {
        if (empty($this->prime_details)) {
            return 'No primes applied';
        }

        return collect($this->prime_details)->map(function ($prime) {
            return sprintf(
                "%s: %s%% = %s",
                $prime['prime_title'],
                $prime['index_prime'],
                number_format($prime['mont_prime'], 2)
            );
        })->implode('<br>');
    }
}