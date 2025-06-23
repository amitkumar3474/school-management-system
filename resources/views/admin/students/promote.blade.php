@extends('admin.layouts.app')
@section('styles')
    <style>
        .table thead th {
            vertical-align: top;
        }
        .btn-circle {
            padding: 5px 13px;
            font-size: 13px;
            line-height: 1.4;
            text-align: center;
            border-radius: 500px;
            height: 29px;
            min-width: 29px;
            margin: 0 1.6px;
            white-space: nowrap !important;
        }
    </style>
@endsection
@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @lang('Student Promotion')
                    </div>
                    <form method="GET" action=""  id="promoteForm">
                        <div class="card-body">
                            <div class="row">  
                                <div class="col-md-3">
                                    <label for="class_id">@lang('Academic Session') <span class="text-danger">*</span></label>
                                    <select name="session_id" id="session_id" class="form-control" required>
                                        <option value="">-- @lang('Select Academic Session') --</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}" {{ (request('session_id')) == $session->id ? 'selected' : '' }}>
                                                {{ $session->session }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>                  
                                <div class="col-md-3 mb-sm">
                                    <label for="class_id">@lang('Class') <span class="text-danger">*</span></label>
                                    <div class="input-group">
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
                                </div>
                    
                                <div class="col-md-3 mb-sm">
                                    <label for="section_id">@lang('Section') </label>
                                    <select name="section_id" id="section_id" class="form-control">
                                        <option value="">-- @lang('Select Section') --</option>
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
                    @if(count($student_enrolls))
                        <div class="card-body">                        
                        <form method="POST" action="{{ route('admin.students.promoteSubmit') }}">
                            @csrf
                            <div class="card-body" style="padding: 0;">
                                <div class="row">
                                    <div class="col-md-4 mb-sm">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Promote To Session')<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select name="promote_year_id" class="form-control" data-plugin-selecttwo="" id="promote_year_id" data-minimum-results-for-search="Infinity" tabindex="-1" aria-hidden="true" required>
                                                    <option value="" selected="selected">--@lang('Select academic year')--</option>
                                                    @foreach ($sessions as $session)
                                                        <option value="{{ $session->id }}" {{ old('promote_year_id') == $session->id ? 'selected' : '' }}>{{ $session->session }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('promote_year_id') <div class="text-danger">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                        
                                    <div class="col-md-4 mb-sm">
                                        <label for="class_id">@lang('Promote To Class') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select name="promote_class_id" id="promote_class_id" class="form-control" required>
                                                <option value="">-- @lang('Select Class') --</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}" {{ old('promote_class_id') == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('promote_class_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                        
                                    <div class="col-md-4 mb-sm">
                                        <label for="promote_section_id">@lang('Promote To Section') <span class="text-danger">*</span></label>
                                        <select name="promote_section_id" id="promote_section_id" class="form-control" required>
                                            <option value="">-- @lang('Select Section') --</option>
                                        </select>
                                    </div>
                                </div>
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead class="card-header">
                                        <tr>
                                            <th class="center">
                                                <div class="checkbox-replace">
                                                    <label class="i-checks" data-toggle="tooltip" data-original-title="Promotion"><input type="checkbox" id="selectAllchkbox" checked=""><i></i></label>
                                                </div>				
                                            </th>
                                            <th>#</th>
                                            <th>@lang('Student Name')</th>
                                            <th>@lang('Admission No')</th>
                                            <th>@lang('Guardian Name')</th>
                                            <th>@lang('Mark Summary')</th>
                                            <th>@lang('Class')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $count = 1;
                                        @endphp
                                        @foreach($student_enrolls as $key => $student_enroll)
                                            <tr>
                                                <input type="hidden" name="student_id[]" value="{{ $student_enroll->student_id }}">
                                                <td class="center checked-area">
                                                    <div class="pt-csm checkbox-replace">
                                                        <label class="i-checks"><input type="checkbox" checked="" name="enroll_id[]" value="{{ $student_enroll->id }}"><i></i></label>
                                                    </div>
                                                </td>
                                                <td>{{  $count++ }}</td>
                                                <td>{{ $student_enroll->student->student_name }}</td>
                                                <td>{{ $student_enroll->student->detail->admission_no ?? 'N/A' }}</td>
                                                <td>{{ $student_enroll->student->guardianDetail->father_name }}</td>
                                                <td><a target="_blank" href="{{ route('admin.students.show',$student_enroll->id ) }}" class="btn btn-default btn-circle" >
                                                    <i class="fas fa-eye"></i> @lang('View')</a></td>
                                                <td class="text-center">
                                                    <div class="d-flex justify-content-start">
                                                        @foreach(['R' => 'Running', 'P' => 'Promoted'] as $code => $label)
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input attendance-radio" type="radio" value="{{ $code }}" name="class_status[{{ $key }}]"
                                                                    id="{{ strtolower($code) }}status_{{ $key }}" {{ old("class_status.$key", 'P') === $code ? 'checked' : '' }}  required >
                                                                <label class="form-check-label" for="{{ strtolower($code) }}status_{{ $key }}">
                                                                    @lang($label)
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>        
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer d-flex justify-content-end align-items-center">
                                <button class="btn btn-primary"><i class="fas fa-plus-circle"></i>  @lang('Promotion') </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning">@lang('No students found for this class and section').</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <script>
        function loadSections(classId, targetSelectId, selectedSectionId = '') {
            let url = "{{ route('admin.get.sections', ':id') }}".replace(':id', classId);

            $(`#${targetSelectId}`).html('<option value="">Loading...</option>');

            if (classId) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $(`#${targetSelectId}`).empty().append('<option value="">-- Select Section --</option>');
                        $.each(data, function(key, section) {
                            let selected = section.id == selectedSectionId ? 'selected' : '';
                            $(`#${targetSelectId}`).append(`<option value="${section.id}" ${selected}>${section.name}</option>`);
                        });
                    },
                    error: function() {
                        $(`#${targetSelectId}`).html('<option value="">Error fetching sections</option>');
                    }
                });
            } else {
                $(`#${targetSelectId}`).html('<option value="">-- Select Section --</option>');
            }
        }
        
        $(document).ready(function() {
            $('#promote_class_id').on('change', function () {
                let classId = $(this).val();
                loadSections(classId, 'promote_section_id');
            });

            // Filter Class change
            $('#class_id').on('change', function () {
                let classId = $(this).val();
                loadSections(classId, 'section_id');
            });

            const teacherId = $('#class_id').val();
            if (teacherId) {
                $('#class_id').trigger('change');
                // loadSections(classId, 'section_id');
            }
            let promoteClassId = $('#promote_class_id').val();
            if (promoteClassId) {
                loadSections(promoteClassId, 'promote_section_id', "{{ request('promote_section_id') }}");
            }
        });
        $('#selectAllchkbox').on('change', function () {
            let isChecked = $(this).is(':checked');
            $('input[name="enroll_id[]"]').prop('checked', isChecked);
        });
        // $(document).ready(function() {
        //     $("#promoteForm").validate({
        //         rules: {
        //             class_id: {
        //                 required: true
        //             }
        //         },
        //         messages: {
        //             class_id: {
        //                 required: "Please select a class"
        //             }
        //         },
        //         errorElement: 'div',
        //         errorClass: 'text-danger',
        //         highlight: function(element) {
        //             $(element).addClass('is-invalid');
        //         },
        //         unhighlight: function(element) {
        //             $(element).removeClass('is-invalid');
        //         }
        //     });
        // });
    </script>
@endsection
