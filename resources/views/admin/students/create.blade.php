@extends('admin.layouts.app')
@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="fas fa-graduation-cap"></i></i> @lang('Student Admission')</h3>
                    </div>
                    <form action="{{ route('admin.students.store') }}" class="frm-submit-data" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            <div class="headers-line mt-md"><i class="fas fa-user-check"></i> @lang('Student Details')</div>
                            <div class="row">
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Academic Year')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select name="year_id" class="form-control" data-plugin-selecttwo="" id="year_id" data-minimum-results-for-search="Infinity" tabindex="-1" aria-hidden="true">
                                                <option value="" selected="selected">@lang('Select academic year')</option>
                                                @foreach ($sessions as $session)
                                                    <option value="{{ $session->id }}" {{ old('year_id') == $session->id ? 'selected' : '' }}>{{ $session->session }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('year_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Student Name')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                                            <input type="text" name="student_name" value="{{ old('student_name') }}" class="form-control" placeholder="@lang('Enter student name')" required>
                                        </div>
                                        @error('student_name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Father`s Name')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="father_name" value="{{ old('father_name') }}" class="form-control" placeholder="@lang('Enter father name')" required>
                                        </div>
                                        @error('father_name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Mother`s Name')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="mother_name" value="{{ old('mother_name') }}" class="form-control" placeholder="@lang('Enter mother name')" required>
                                        </div>
                                        @error('mother_name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Date of Birth')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            <input type="date" name="dob" value="{{ old('dob') }}" class="form-control" placeholder="@lang('Enter date of birth')" required>
                                        </div>
                                        @error('dob') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Gender')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select name="gender" class="form-control" data-plugin-selecttwo="" data-width="100%" data-minimum-results-for-search="Infinity" tabindex="-1" aria-hidden="true">
                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>@lang('Male')</option>
                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>@lang('Female')</option>
                                            </select>
                                        </div>
                                        @error('gender') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Caste/Category')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select name="caste" class="form-control" data-plugin-selecttwo="" id="caste" data-minimum-results-for-search="Infinity" tabindex="-1" aria-hidden="true">
                                                <option value="" selected="selected">@lang('Select Category')</option>
                                                <option value="1" {{ old('caste') == 1 ? 'selected' : '' }}>@lang('General')</option>
                                                <option value="2" {{ old('caste') == 2 ? 'selected' : '' }}>@lang('Science')</option>
                                                <option value="3" {{ old('caste') == 3 ? 'selected' : '' }}>@lang('Commerce')</option>
                                            </select>
                                        </div>
                                        @error('caste') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Guardian Mobile')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone-volume"></i></span>
                                            <input type="text" name="guardian_mobile" value="{{ old('guardian_mobile') }}" class="form-control" placeholder="@lang('Enter guardian mobile')" required>
                                        </div>
                                        @error('guardian_mobile') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Class')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select name="class_id" class="form-control" data-plugin-selecttwo="" id="class_id" data-minimum-results-for-search="Infinity" tabindex="-1" >
                                                <option value="" selected="selected">@lang('Select Class')</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('class_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Sections')</label>
                                        <div class="input-group">
                                            <select name="section_id" class="form-control" data-plugin-selecttwo="" id="section_id" data-minimum-results-for-search="Infinity" tabindex="-1" >
                                                <option value="" selected="selected">@lang('Select Class')</option>
                                            </select>
                                        </div>
                                        @error('section_id') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Roll No')</label>
                                        <div class="input-group">
                                            <input type="text" name="roll_no" value="{{ old('roll_no') }}" class="form-control" placeholder="@lang('Enter roll no')" >
                                        </div>
                                        @error('roll_no') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label for="photo">@lang('Student Photo') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="file" name="photo" id="photo" class="form-control" >
                                        </div>
                                        @error('photo') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing" class="btn btn-primary d-feex justify-content-end">
                                <i class="fas fa-plus-circle"></i> @lang('Save')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#class_id').on('change', function() {
            var classId = $(this).val();
            var url = "{{ route('admin.get.sections', ':id') }}".replace(':id', classId);
            $('#section_id').html('<option value="">Loading...</option>');

            if (classId) {
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(data) {
                        $('#section_id').empty().append('<option value="">Select Section</option>');
                        $.each(data, function(key, section) {                            
                            $('#section_id').append('<option value="' + section.id + '">' + section.name + '</option>');
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
    });
</script>
@endsection