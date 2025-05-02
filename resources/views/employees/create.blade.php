@extends('layouts.app')
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

@section('content')
<div class="container">
    <h1>Create New Employee</h1>
    
    <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <h3>Personal Information</h3>
                
                <div class="form-group">
                    <label for="nomAr">Nom (Arabic)</label>
                    <input type="text" class="form-control arabic-input" id="nomAr" name="nomAr" required>
                </div>
                
                <div class="form-group">
                    <label for="prenAr">Prénom (Arabic)</label>
                    <input type="text" class="form-control arabic-input" id="prenAr" name="prenAr" required>
                </div>
                
                <div class="form-group">
                    <label for="nomFr">Nom (French)</label>
                    <input type="text" class="form-control" id="nomFr" name="nomFr" required>
                </div>
                
                <div class="form-group">
                    <label for="prenFr">Prénom (French)</label>
                    <input type="text" class="form-control" id="prenFr" name="prenFr" required>
                </div>
                
                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" required>
                </div>
                
                <div class="form-group">
                    <label for="ddn">Date of Birth</label>
                    <input type="date" class="form-control" id="ddn" name="ddn" required>
                </div>
                
                <div class="form-group">
                    <label for="ldn">Place of Birth</label>
                    <input type="text" class="form-control" id="ldn" name="ldn" required>
                </div>
                
                <div class="form-group">
                    <label for="sit_famill">Family Situation</label>
                    <select class="form-control" id="sit_famill" name="sit_famill" required>
                        <option value="0">Single</option>
                        <option value="1">Married with Foyer</option>
                        <option value="2">Married without Foyer</option>
                    </select>
                </div>
                
                <div class="form-group" id="nbrEnfantGroup">
                    <label for="nbrEnfant">Number of Children</label>
                    <input type="number" class="form-control" id="nbrEnfant" name="nbrEnfant" min="0">
                </div>
                
                <div class="form-group" id="plus10Group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="Plus10" name="Plus10" value="1">
                        <label class="form-check-label" for="Plus10">Plus 10</label>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="endicape" name="endicape" value="1">
                        <label class="form-check-label" for="endicape">Endicape</label>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <h3>Professional Information</h3>
                
                <div class="form-group">
                    <label for="ccp">CCP Date</label>
                    <input type="date" class="form-control" id="ccp" name="ccp" required>
                </div>
                
                <div class="form-group">
                    <label for="dateRecrut">Recruitment Date</label>
                    <input type="date" class="form-control" id="dateRecrut" name="dateRecrut" required>
                </div>
                
                <div class="form-group">
                    <label for="lastGraduation">Last Graduation Date</label>
                    <input type="date" class="form-control" id="lastGraduation" name="lastGraduation" required>
                </div>
                
                <div class="form-group">
                    <label for="cat">Category</label>
                    <input type="number" class="form-control" id="cat" name="cat" required>
                </div>
                
                <div class="form-group">
                    <label for="echelon">Echelon</label>
                    <input type="number" class="form-control" id="echelon" name="echelon" required>
                </div>
                
                <div class="form-group">
                    <label for="nbrAnneeExperience">Years of Experience</label>
                    <input type="number" class="form-control" id="nbrAnneeExperience" name="nbrAnneeExperience" required>
                </div>
                
                <div class="form-group">
                    <label for="groupe_id">Groupe</label>
                    <select class="form-control" id="groupe_id" name="groupe_id" required>
                        <option value="">Select Groupe</option>
                        @foreach($groupes as $groupe)
                            <option value="{{ $groupe->id }}">{{ $groupe->title }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="fonction_id">Fonction</label>
                    <select class="form-control" id="fonction_id" name="fonction_id" required>
                        <option value="">Select Groupe first</option>
                    </select>
                </div>
                
                <div class="form-group" id="primesGroup">
                    <label>Primes</label>
                    <div id="primesContainer">
                        <p>Select a groupe first</p>
                    </div>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Save Employee</button>
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$(document).ready(function() {
    // ... other code ...
    $(document).ready(function() {
    // Function to toggle Plus10 visibility
    function togglePlus10Visibility() {
        const nbrEnfant = parseInt($('#nbrEnfant').val()) || 0;
        if (nbrEnfant > 0) {
            $('#plus10Group').show(); // Show if children > 0
        } else {
            $('#plus10Group').hide(); // Hide if children = 0
            $('#Plus10').prop('checked', false); // Uncheck
        }
    }

    // Initial check on page load
    togglePlus10Visibility();

    // Update on input change
    $('#nbrEnfant').on('input', togglePlus10Visibility);

    function toggleGroupeFields() {
        const groupeId = $('#groupe_id').val();
        console.log(groupeId); // Debugging line
        
        if (groupeId == '1') { // If Groupe 1 is selected
            $('#catGroup').show();      // Show Catégorie
            $('#echelonGroup').show(); // Show Echelon
            $('#nbrAnneeExperienceGroup').hide(); // Hide Années d'Expérience
        } else { // For other Groupes
            $('#catGroup').hide();      // Hide Catégorie
            $('#echelonGroup').hide();  // Hide Echelon
            $('#nbrAnneeExperienceGroup').show(); // Show Années d'Expérience
        }
    }

    // Initial toggle on page load
    toggleGroupeFields();

    // Update on Groupe change
    $('#groupe_id').change(toggleGroupeFields);

    // Also handle family situation changes
    $('#sit_famill').change(function() {
        const sitFamill = $(this).val();
        if (sitFamill === '0') { // Single
            $('#nbrEnfantGroup').hide();
            $('#plus10Group').hide();
            $('#nbrEnfant').val('0');
            $('#Plus10').prop('checked', false);
        } else { // Married (with/without foyer)
            $('#nbrEnfantGroup').show();
            togglePlus10Visibility(); // Re-check children count
        }
    });
});
    // Get fonctions when groupe changes
    $('#groupe_id').change(function() {
        

    // Update on input change
   
        const groupeId = $(this).val();
        if (groupeId) {
            // Using named route
            $.get("{{ route('fonctions-by-groupe') }}", { 
                groupe_id: groupeId 
            }, function(data) {
                $('#fonction_id').empty().append('<option value="">Select Fonction</option>');
                $.each(data, function(key, value) {
                    $('#fonction_id').append(`<option value="${value.id}">${value.title}</option>`);
                });
            }).fail(function(xhr, status, error) {
                console.error("Error fetching fonctions:", error);
            });
            
            const cat = $('#cat').val() || 1;
            // Using named route
            $.get("{{ route('primes-by-groupe') }}", { 
                groupe_id: groupeId, 
                cat: cat 
            }, function(data) {
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
            }).fail(function(xhr, status, error) {
                console.error("Error fetching primes:", error);
            });
        } else {
            $('#fonction_id').empty().append('<option value="">Select Groupe first</option>');
            $('#primesContainer').empty().append('<p>Select a groupe first</p>');
        }
    });

    // ... rest of your code ...
});
</script>

@endsection