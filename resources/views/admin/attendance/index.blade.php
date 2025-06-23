@extends('admin.layouts.app')
@section('styles')
    
@endsection
@section('panel')
@php
    $selectedDate = \Carbon\Carbon::parse(request('date', now()));
@endphp
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        @lang('Student Attendance')
                    </div>
                    <form method="GET" action=""  id="attendanceForm">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="attendance_type">@lang('Attendance Type')</label>
                                    <select name="attendance_type" id="attendance_type" class="form-control">
                                        <option value="daily" {{ request('attendance_type') == 'daily' ? '' : 'selected' }}>@lang('Daily')</option>
                                        <option value="monthly" {{ request('attendance_type') == 'monthly' ? 'selected' : '' }}>@lang('Monthly')</option>
                                    </select>
                                </div>

                                <div class="col-md-3" id="daily_input" style="display: {{ request('attendance_type') == 'monthly' ? 'none' : 'block' }};">
                                    <label for="date">@lang('Date') <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                                    @error('date') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-3" id="monthly_input" style="display: {{ request('attendance_type') == 'monthly' ? 'block' : 'none' }};">
                                    <label for="month">@lang('Month') <span class="text-danger">*</span></label>
                                    <input type="month" name="month" class="form-control" value="{{ request('month') }}">
                                    @error('month') <div class="text-danger">{{ $message }}</div> @enderror
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
                    @if(count($student_enrolls) && request('attendance_type') == 'daily')
                        <div class="card-header">
                            @if(request('attendance_type') == 'daily' && $attendanceExists)
                                <div class="alert alert-warning">
                                    {{ __("Today's attendance has already been submitted. Would you like to edit it?") }}
                                </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title mb-0"><i class="fas fa-users"></i> @lang('Students List')</h3>
                                <div class="input-group-sm">
                                    <label class="control-label">@lang('Select For Everyone') <span class="text-danger">*</span></label>
                                    <select name="mark_all_everyone" class="form-control" onchange="selAtten_all(this.value)" data-plugin-selecttwo="" data-width="100%" data-minimum-results-for-search="Infinity" tabindex="-1" aria-hidden="true">
                                        <option value="" selected="selected">@lang('Not Selected')</option>
                                        <option value="P">@lang('Present')</option>
                                        <option value="A">@lang('Absent')</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- @dd($student_enrolls) --}}
                        @if($selectedDate->isSunday())
                            <div class="alert alert-warning">
                                {{ __("Note: The selected date is a Sunday. Do you still want to record attendance?") }}
                            </div>
                        @else
                            <form method="POST" action="{{ route('admin.attendance.store') }}">
                                @csrf
                                <input type="hidden" name="att_date" value="{{ request('date', date('Y-m-d')) }}">
                                <div class="card-body">
                                    <table id="example2" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>@lang('Student Name')</th>
                                                <th>@lang('Roll')</th>
                                                <th>@lang('Admission No')</th>
                                                <th>@lang('Status')</th>
                                                <th>@lang('Remarks')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($student_enrolls as $key => $student_enroll)
                                                <input type="hidden" name="enroll_ids[]" value="{{ $student_enroll->id }}">
                                                <input type="hidden" name="att_type" value="{{ request('attendance_type') }}">
                                                <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                                                <input type="hidden" name="section_id" value="{{ request('section_id') }}">
                                                <tr>
                                                    <td>{{ $student_enroll->student->student_name }}</td>
                                                    <td>{{ $student_enroll->roll_no }}</td>
                                                    <td>{{ $student_enroll->student->detail->admission_no ?? 'N/A' }}</td>
                                                    <td class="text-center">
                                                        <div class="d-flex justify-content-start">
                                                            @foreach(['P' => 'Present', 'A' => 'Absent'] as $code => $label)
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input attendance-radio" type="radio" value="{{ $code }}" name="attendance[{{ $key }}][status]"
                                                                        id="{{ strtolower($code) }}status_{{ $key }}" {{ isset($student_enroll->attendance_status) && $student_enroll->attendance_status === $code ? 'checked' : '' }} required >
                                                                    <label class="form-check-label" for="{{ strtolower($code) }}status_{{ $key }}">
                                                                        @lang($label)
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="attendance[{{ $key }}][remark]" type="text" value="{{ $student_enroll->attendance_remark ?? '' }}" placeholder="@lang('Remarks')">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer d-flex justify-content-end align-items-center">
                                    <button class="btn btn-primary"><i class="fas fa-plus-circle"></i>  @lang('Submit Attendance') </button>
                                </div>
                            </form>
                        @endif
                    @elseif(count($student_enrolls)  && request('attendance_type') == 'monthly')
                        @php
                                $monthDate = request('month') ? \Carbon\Carbon::parse(request('month')) : now();
                        @endphp
                        <div class="card-header">
                            @if(request('attendance_type') == 'monthly' && $attendanceExists)
                                <div class="alert alert-warning">
                                    {{ __("This month's attendance has already been submitted. Would you like to edit it?") }}
                                </div>
                            @endif
                            <div class="d-flex justify-content-start align-items-center">
                                <h3 class="card-title mb-0"><i class="fas fa-users"></i> @lang('Students Monthly Attendance'): {{ $monthDate->format('F Y') }}</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.attendance.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="month" value="{{ request('month', date('Y-m')) }}">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <tr>
                                                <th>@lang('Student Name')</th>
                                                <th>@lang('Present')</th>
                                                <th>@lang('Absent')</th>
                                            </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($student_enrolls as $student_enroll)
                                            <input type="hidden" name="enroll_ids[]" value="{{ $student_enroll->id }}">
                                            <input type="hidden" name="att_type" value="{{ request('attendance_type') }}">
                                            <input type="hidden" name="class_id" value="{{ request('class_id') }}">
                                            <input type="hidden" name="section_id" value="{{ request('section_id') }}">
                                            <tr>
                                                <td>{{ $student_enroll->student->student_name }}</td>
                                            
                                                <td class="text-center">
                                                    <input  type="number"  name="attendance[{{ $student_enroll->id }}][present]" 
                                                        value="{{ old('attendance.' . $student_enroll->id . '.present', $student_enroll->present_count ?? 0) }}" 
                                                        min="0"  class="form-control text-success"  />
                                                </td>
                                            
                                                <td class="text-center">
                                                    <input type="number"  name="attendance[{{ $student_enroll->id }}][absent]" 
                                                        value="{{ old('attendance.' . $student_enroll->id . '.absent', $student_enroll->absent_count ?? 0) }}" 
                                                        min="0"  class="form-control text-danger"  />
                                                </td>
                                            </tr>                                            
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="card-footer d-flex justify-content-end align-items-center">
                                    <button class="btn btn-primary"><i class="fas fa-plus-circle"></i>  @lang('Submit Attendance') </button>
                                </div>
                            </form>
                        </div>
                    @elseif(request('class_id'))
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
        $('#attendance_type').on('change', function () {
            if ($(this).val() === 'monthly') {
                $('#daily_input').hide();
                $('#monthly_input').show();
            } else {
                $('#daily_input').show();
                $('#monthly_input').hide();
            }
        });

        function selAtten_all(value) {            
            if (!value) return;

            document.querySelectorAll('.attendance-radio').forEach(function (radio) {
                if (radio.value === value) {
                    radio.checked = true;
                }
            });
        }
        $('#class_id').on('change', function() {
            var classId = $(this).val();
            var selectedSectionId = "{{ request('section_id') ?? '' }}";
            var url = "{{ route('admin.get.sections', ':id') }}".replace(':id', classId);
            $('#section_id').html('<option value="">Loading...</option>');

            if (classId) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('#section_id').empty().append('<option value="">Select Section</option>');
                        $.each(data, function(key, section) {                            
                            var isSelected = section.id == selectedSectionId ? 'selected' : '';
                            $('#section_id').append('<option value="' + section.id + '" ' + isSelected + '>' + section.name + '</option>');
                        });
                    },
                    error: function() {
                        $('#section_id').html('<option value="">Error fetching sections</option>');
                    }
                });
            } else {
                $('#section_id').html('<option value="">Select Section</option>');
            }
        });
        $(document).ready(function() {
            const teacherId = $('#class_id').val();
            if (teacherId) {
                $('#class_id').trigger('change');
            }
        });
    </script>
@endsection
