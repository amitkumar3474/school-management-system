<div class="row assignment-row mb-3 border p-3">
    <div class="col-md-3">
        <label>Class</label>
        <select name="class_id[]" class="form-control class-dropdown" required>
            <option value="">Select Class</option>
            @foreach($classes as $class)
                <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label>Section</label>
        <select name="section_id[]" class="form-control section-dropdown" required>
            <option value="">Select Section</option>
        </select>
    </div>
    <div class="col-md-4">
        <label>Subjects</label>
        <select name="subject_id[{{ $index }}][]" class="form-control select2 subject-dropdown" multiple="multiple" required></select>
    </div>
    @if($index != 0)
        <div class="col-md-2 text-left mt-4" style="padding-top: 9px;">
            <button type="button" class="btn btn-danger removeRow"><i class="fas fa-times"></i></button>
        </div>
    @endif
</div>
