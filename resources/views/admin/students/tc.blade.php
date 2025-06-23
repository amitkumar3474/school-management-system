@extends('admin.layouts.app')
@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @lang('Select Ground')
                    </div>
                    <form method="GET" action=""  id="attendanceForm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="class_id">@lang('Academic Session') <span class="text-danger">*</span></label>
                                    <select name="session_id" id="session_id" class="form-control" required>
                                        <option value="">-- @lang('Select Academic Session') --</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}" {{ (request('session_id') ?? $defaultSessionId) == $session->id ? 'selected' : '' }}>
                                                {{ $session->session }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="class_id">@lang('Class') <span class="text-danger">*</span></label>
                                    <select name="class_id" id="class_id" class="form-control" required>
                                        <option value="">-- @lang('Select Class') --</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('class_id') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                    
                                <div class="col-md-3">
                                    <label for="section_id">@lang('Section') </label>
                                    <select name="section_id" id="section_id" class="form-control">
                                        <option value="">-- @lang('Select Section') --</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="section_id">@lang('Student Name') <span class="text-danger">*</span></label>
                                    <select name="student_id" id="student_id" class="form-control" required>
                                        <option value="">-- @lang('Select student') --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end align-items-center">
                            <button class="btn btn-primary"><i class="fas fa-filter"></i>  @lang('Filter') </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center gap-2">
                            <h3 class="card-title mb-0 pr-3"><i class="fab fa-buromobelexperte"></i> @lang('Student List')</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>@lang('Photo')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Father')</th>
                                    <th>@lang('Class')</th>
                                    <th>@lang('Saction')</th>
                                    <th>@lang('Mobile')</th>
                                    <th>@lang('Status')</th>
                                    <th width="180">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $enrollment)
                                    <tr>
                                        <td style="text-align: center;">
                                            <img src="{{ $enrollment->student->photo ? asset('storage/' . $enrollment->student->photo) : asset('admin/images/user.png') }}" alt="@lang('Student Photo')" class="" width="50" height="50">
                                        </td>
                                        <td><a href="{{ route('admin.students.show', $enrollment->id) }}" target="_blank">{{ $enrollment->student->student_name }}</a></td>
                                        <td>{{ $enrollment->student->father_name }}</td>
                                        <td><span class="badge bg-info">{{ $enrollment->class->name }}</span></td>
                                        <td>
                                            @if($enrollment->section)
                                                <span class="badge bg-warning">{{ $enrollment->section->name }}</span>
                                            @else
                                                <span class="text-muted">@lang('No sections')</span>
                                            @endif
                                        </td>                                        
                                        <td>{{ $enrollment->student->guardian_mobile }}</td>
                                        <td>
                                            @if($enrollment->generate_tc)
                                                <span class="badge bg-success">TC Generated</span>
                                            @else
                                                <span class="badge bg-secondary">Not Generated</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$enrollment->generate_tc)
                                                <form action="{{ route('admin.students.markTcGenerated', $enrollment->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-success generate_TC" title="Generate TC">
                                                        <i class="fas fa-certificate"></i> @lang('Generate TC')
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">@lang('No permissions found').</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $students->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {

        function loadStudents() {
            let classId = $('#class_id').val();
            let sectionId = $('#section_id').val();
            var selectedStudentId = "{{ request('student_id') ?? '' }}";
            if (!classId) {
                $('#student_id').html('<option value="">-- Select student --</option>');
                return;
            }

            let url = "{{ route('admin.get.students', [':classId', ':sectionId']) }}"
                .replace(':classId', classId)
                .replace(':sectionId', sectionId ?? '');

            $('#student_id').html('<option>Loading...</option>');

            $.get(url, function (students) {
                $('#student_id').empty().append('<option value="">-- Select student --</option>');
                $.each(students, function (index, student) {
                    let selected = student.id == selectedStudentId ? 'selected' : '';
                    $('#student_id').append(`<option value="${student.id}" ${selected}>${student.name}</option>`);
                });
            });
        }

        // Load students when class or section changes
        $('#class_id').on('change', function () {
            loadSections(); // also load sections
            loadStudents(); // load students
        });

        $('#section_id').on('change', function () {
            loadStudents(); // filter students by section
        });

        function loadSections() {
            var classId = $('#class_id').val();
            var selectedSectionId = "{{ request('section_id') ?? '' }}";
            var url = "{{ route('admin.get.sections', ':id') }}".replace(':id', classId);

            $('#section_id').html('<option value="">Loading...</option>');

            if (classId) {
                $.get(url, function (data) {
                    $('#section_id').empty().append('<option value="">-- Select Section --</option>');
                    $.each(data, function (index, section) {
                        let selected = section.id == selectedSectionId ? 'selected' : '';
                        $('#section_id').append(`<option value="${section.id}" ${selected}>${section.name}</option>`);
                    });
                });
            }
        }

        // Trigger change if already selected
        if ($('#class_id').val()) {
            $('#class_id').trigger('change');
        }
        if ($('#section_id').val()) {
            $('#section_id').trigger('change');
        }

        $('.generate_TC').on('click', function (e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Generate TC?',
                text: "Are you sure you want to mark this student's TC as generated?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, generate it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

    });
</script>
@endsection