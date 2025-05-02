@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Employee</h1>
    
    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6">
                <h3>Personal Information</h3>
                
                <div class="form-group">
                    <label for="nomAr">Nom (Arabic)</label>
                    <input type="text" class="form-control arabic-input" id="nomAr" name="nomAr" value="{{ $employee->nomAr }}" required>
                </div>
                
                <div class="form-group">
                    <label for="prenAr">Prénom (Arabic)</label>
                    <input type="text" class="form-control arabic-input" id="prenAr" name="prenAr" value="{{ $employee->prenAr }}" required>
                </div>
                
                <div class="form-group">
                    <label for="nomFr">Nom (French)</label>
                    <input type="text" class="form-control" id="nomFr" name="nomFr" value="{{ $employee->nomFr }}" required>
                </div>
                
                <div class="form-group">
                    <label for="prenFr">Prénom (French)</label>
                    <input type="text" class="form-control" id="prenFr" name="prenFr" value="{{ $employee->prenFr }}" required>
                </div>
                
                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $employee->mobile }}" required>
                </div>
                
                <div class="form-group">
                    <label for="ddn">Date of Birth</label>
                    <input type="date" class="form-control" id="ddn" name="ddn" value="{{ $employee->ddn->format('Y-m-d') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="ldn">Place of Birth</label>
                    <input type="text" class="form-control" id="ldn" name="ldn" value="{{ $employee->ldn }}" required>
                </div>
                
                <div class="form-group">
                    <label for="sit_famill">Family Situation</label>
                    <select class="form-control" id="sit_famill" name="sit_famill" required>
                        <option value="0" {{ $employee->sit_famill == 0 ? 'selected' : '' }}>Single</option>
                        <option value="1" {{ $employee->sit_famill == 1 ? 'selected' : '' }}>Married with Foyer</option>
                        <option value="2" {{ $employee->sit_famill == 2 ? 'selected' : '' }}>Married without Foyer</option>
                    </select>
                </div>
                
                <div class="form-group" id="nbrEnfantGroup" style="{{ $employee->sit_famill == 0 ? 'display:none;' : '' }}">
                    <label for="nbrEnfant">Number of Children</label>
                    <input type="number" class="form-control" id="nbrEnfant" name="nbrEnfant" min="0" value="{{ $employee->nbrEnfant }}">
                </div>
                
                <div class="form-group" id="plus10Group" style="{{ $employee->sit_famill == 0 || $employee->nbrEnfant == 0 ? 'display:none;' : '' }}">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="Plus10" name="Plus10" value="1" {{ $employee->Plus10 ? 'checked' : '' }}>
                        <label class="form-check-label" for="Plus10">Plus 10</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="endicape" name="endicape" value="1" {{ $employee->endicape ? 'checked' : '' }}>
                        <label class="form-check-label" for="endicape">Endicape</label>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <h3>Professional Information</h3>
                
                <div class="form-group">
                    <label for="ccp">CCP Date</label>
                    <input type="date" class="form-control" id="ccp" name="ccp" value="{{ $employee->ccp->format('Y-m-d') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="dateRecrut">Recruitment Date</label>
                    <input type="date" class="form-control" id="dateRecrut" name="dateRecrut" value="{{ $employee->dateRecrut->format('Y-m-d') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="lastGraduation">Last Graduation Date</label>
                    <input type="date" class="form-control" id="lastGraduation" name="lastGraduation" value="{{ $employee->lastGraduation->format('Y-m-d') }}" required>
                </div>
                
                <div class="form-group">
                    <label for="cat">Category</label>
                    <input type="number" class="form-control" id="cat" name="cat" value="{{ $employee->cat }}" required>
                </div>
                
                <div class="form-group">
                    <label for="echelon">Echelon</label>
                    <input type="number" class="form-control" id="echelon" name="echelon" value="{{ $employee->echelon }}" required>
                </div>
                
                <div class="form-group">
                    <label for="nbrAnneeExperience">Years of Experience</label>
                    <input type="number" class="form-control" id="nbrAnneeExperience" name="nbrAnneeExperience" value="{{ $employee->nbrAnneeExperience }}" required>
                </div>
                
                <div class="form-group">
                    <label for="groupe_id">Groupe</label>
                    <select class="form-control" id="groupe_id" name="groupe_id" required>
                        <option value="">Select Groupe</option>
                        @foreach($groupes as $groupe)
                            <option value="{{ $groupe->id }}" {{ $employee->groupe_id == $groupe->id ? 'selected' : '' }}>{{ $groupe->title }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="fonction_id">Fonction</label>
                    <select class="form-control" id="fonction_id" name="fonction_id" required>
                        @foreach($fonctions as $fonction)
                            <option value="{{ $fonction->id }}" {{ $employee->fonction_id == $fonction->id ? 'selected' : '' }}>{{ $fonction->title }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group" id="primesGroup">
                    <label>Primes</label>
                    <div id="primesContainer">
                        @foreach($primes as $prime)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="primes[]" id="prime{{ $prime->id }}" value="{{ $prime->id }}" 
                                    {{ $employee->primes->contains($prime->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="prime{{ $prime->id }}">{{ $prime->title }} ({{ $prime->abrv }}) - {{ $prime->category_range }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Update Employee</button>
    </form>
</div>

<script>
$(document).ready(function() {
    // Toggle children fields based on family situation
    function toggleChildrenFields() {
        const sitFamill = $('#sit_famill').val();
        if (sitFamill === '0') {
            $('#nbrEnfantGroup').hide();
            $('#plus10Group').hide();
            $('#nbrEnfant').val('0');
            $('#Plus10').prop('checked', false);
        } else {
            $('#nbrEnfantGroup').show();
            $('#plus10Group').show();
        }
    }
    
    // Toggle Plus10 based on children count
    function togglePlus10() {
        const nbrEnfant = parseInt($('#nbrEnfant').val()) || 0;
        if (nbrEnfant === 0) {
            $('#Plus10').prop('checked', false);
            $('#plus10Group').hide();
        } else {
            $('#plus10Group').show();
        }
    }
    
    // Initial toggle
    toggleChildrenFields();
    togglePlus10();
    
    // Event listeners
    $('#sit_famill').change(toggleChildrenFields);
    $('#nbrEnfant').on('input', togglePlus10);
    
    // Get fonctions when groupe changes
    $('#groupe_id').change(function() {
        const groupeId = $(this).val();
        if (groupeId) {
            $.get('/employees/fonctions-by-groupe', { groupe_id: groupeId }, function(data) {
                $('#fonction_id').empty();
                $.each(data, function(key, value) {
                    $('#fonction_id').append(`<option value="${value.id}">${value.title}</option>`);
                });
            });
            
            const cat = $('#cat').val() || 1;
            $.get('/employees/primes-by-groupe', { groupe_id: groupeId, cat: cat }, function(data) {
                $('#primesContainer').empty();
                if (data.length > 0) {
                    $.each(data, function(key, prime) {
                        $('#primesContainer').append(`
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="primes[]" id="prime${prime.id}" value="${prime.id}">
                                <label class="form-check-label" for="prime${prime.id}">${prime.title} (${prime.abrv}) - ${prime.category_range}</label>
                            </div>
                        `);
                    });
                } else {
                    $('#primesContainer').append('<p>No primes available for this groupe and category</p>');
                }
            });
        } else {
            $('#fonction_id').empty().append('<option value="">Select Groupe first</option>');
            $('#primesContainer').empty().append('<p>Select a groupe first</p>');
        }
    });
    
    // Update primes when category changes
    $('#cat').on('input', function() {
        const groupeId = $('#groupe_id').val();
        const cat = $(this).val() || 1;
        
        if (groupeId) {
            $.get('/employees/primes-by-groupe', { groupe_id: groupeId, cat: cat }, function(data) {
                $('#primesContainer').empty();
                if (data.length > 0) {
                    $.each(data, function(key, prime) {
                        $('#primesContainer').append(`
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="primes[]" id="prime${prime.id}" value="${prime.id}">
                                <label class="form-check-label" for="prime${prime.id}">${prime.title} (${prime.abrv}) - ${prime.category_range}</label>
                            </div>
                        `);
                    });
                } else {
                    $('#primesContainer').append('<p>No primes available for this groupe and category</p>');
                }
            });
        }
    });
    
    // Auto switch keyboard for Arabic fields
    $('.arabic-input').focus(function() {
        $(this).attr('lang', 'ar');
        $(this).attr('dir', 'rtl');
    }).blur(function() {
        $(this).removeAttr('lang');
        $(this).removeAttr('dir');
    });
});
</script>
@endsection