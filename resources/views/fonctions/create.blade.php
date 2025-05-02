<form method="POST" action="{{ isset($fonction) ? route('fonctions.update', $fonction->id) : route('fonctions.store') }}">
    @csrf
    @if(isset($fonction)) @method('PUT') @endif

    <div class="card">
        <div class="card-header">
            {{ isset($fonction) ? 'Edit' : 'Create' }} Fonction
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" 
                           value="{{ old('title', $fonction->title ?? '') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="abrv" class="col-sm-2 col-form-label">Abbreviation</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="abrv" name="abrv" 
                           value="{{ old('abrv', $fonction->abrv ?? '') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="cat" class="col-sm-2 col-form-label">Category</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="cat" name="cat" 
                           value="{{ old('cat', $fonction->cat ?? '') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="groupe_id" class="col-sm-2 col-form-label">Groupe</label>
                <div class="col-sm-10">
                    <select class="form-select" id="groupe_id" name="groupe_id">
                        <option value="">-- No Groupe --</option>
                        @foreach($groupes as $groupe)
                            <option value="{{ $groupe->id }}"
                                {{ old('groupe_id', $fonction->groupe_id ?? '') == $groupe->id ? 'selected' : '' }}>
                                {{ $groupe->title }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-text">
                        Select which groupe this fonction belongs to
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">
                {{ isset($fonction) ? 'Update' : 'Create' }}
            </button>
        </div>
    </div>
</form>