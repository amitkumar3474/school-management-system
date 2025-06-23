@extends('admin.layouts.app')
@section('panel')

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0"><i class="fas fa-graduation-cap"></i> @lang('Teacher')</h3>
            </div>
            <form action="{{ route('admin.teacher.class.subjects.store') }}" method="POST" class="frm-submit-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>@lang('Teacher') <span class="text-danger">*</span></label>
                        @if(isset($assignment))
                            <input type="text" class="form-control" value="{{ $assignment->teacher->name }}" readonly>
                            <input type="hidden" id="teacher_id" name="teacher_id" value="{{ $assignment->teacher_id }}">
                        @else
                            <select name="teacher_id" id="teacher_id" class="form-control">
                                <option value="">Select Teacher</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ (old('teacher_id') == $teacher->id) ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <div id="assignmentBody">
                        <div class="assignment-row">
                            @include('admin.teachers.partials.assignment_row', ['index' => 0])
                        </div>
                    </div>

                    <button type="button" id="addRow" class="btn btn-success mt-2"><i class="fas fa-plus-circle"></i></button>
                </div>

                <div class="card-footer">
                    <button type="submit" name="action" value="save" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save
                    </button>

                    <button type="submit" name="action" value="save_new" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Save & New
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    $('.select2').select2();
    let rowIndex = 0;
    // Load sections + subjects
    $(document).on('change', '.class-dropdown', function () {
        let classId = $(this).val();
        let row = $(this).closest('.assignment-row');
        let sectionDropdown = row.find('.section-dropdown');
        let subjectDropdown = row.find('.subject-dropdown');

        if (classId) {
            $.get('/admin/get-sections-subjects/' + classId, function (data) {
                sectionDropdown.empty().append('<option value="">Select Section</option>');
                subjectDropdown.empty();

                data.sections.forEach(section => {
                    sectionDropdown.append(`<option value="${section.id}">${section.name}</option>`);
                });

                data.subjects.forEach(subject => {
                    subjectDropdown.append(`<option value="${subject.id}">${subject.name}</option>`);
                });
            });
        }
    });

    // Add new row
    $('#addRow').click(function () {
        $.get('/admin/get-assignment-row/' + rowIndex, function (html) {
            $('#assignmentBody').append(html);
            $('.select2').select2();
            resetRowIndexes();
        });
    });

    // Remove row
    $(document).on('click', '.removeRow', function () {
        if ($('.assignment-row').length > 1) {
            $(this).closest('.assignment-row').remove();
            resetRowIndexes();
        }
    });

    // Load existing assignments on teacher select
    $('#teacher_id').on('change', function () {
        let teacherId = $(this).val();
        if (teacherId) {
            $.get(`/admin/get-teacher-assignments/${teacherId}`, function (data) {
                $('#assignmentBody').empty();

                if (data.length === 0) {
                    $('#addRow').trigger('click');
                    return;
                }

                data.forEach((item, idx) => {
                    $.get('/admin/get-assignment-row/' + idx, function (html) {
                        let row = $(html);
                        $('#assignmentBody').append(row); // append row immediately so it exists in DOM

                        let classDropdown = row.find('.class-dropdown');
                        let sectionDropdown = row.find('.section-dropdown');
                        let subjectDropdown = row.find('.subject-dropdown');

                        classDropdown.val(item.class_id).trigger('change');

                        // Wait for sections and subjects to load
                        $.get('/admin/get-sections-subjects/' + item.class_id, function (data) {
                            sectionDropdown.empty().append('<option value="">Select Section</option>');
                            subjectDropdown.empty();

                            data.sections.forEach(section => {
                                sectionDropdown.append(`<option value="${section.id}">${section.name}</option>`);
                            });

                            data.subjects.forEach(subject => {
                                subjectDropdown.append(`<option value="${subject.id}">${subject.name}</option>`);
                            });

                            sectionDropdown.val(item.section_id).trigger('change');
                            subjectDropdown.val(item.subject_ids ?? [item.subject_id]).trigger('change'); // handle array or single
                            $('.select2').select2();
                        });
                    });
                });
                rowIndex = data.length;
            });
        }
    });

    function resetRowIndexes() {
        $('.assignment-row').each(function(index) {
            $(this).find('.subject-dropdown').attr('name', `subject_id[${index}][]`);
        });

        // Update global rowIndex to prevent conflict
        rowIndex = $('.assignment-row').length;
    }

    $(document).ready(function () {
        const teacherId = $('#teacher_id').val();
        if (teacherId) {
            $('#teacher_id').trigger('change');
        }
    });

</script>
@endsection
