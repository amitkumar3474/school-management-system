@extends('admin.layouts.app')
@section('panel')
@php
    $isEdit = isset($teacher);
@endphp
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="fas fa-graduation-cap"></i></i> @lang('Teacher')</h3>
                    </div>
                    <form action="{{ $isEdit ? route('admin.teachers.update', $teacher) : route('admin.teachers.store') }}" class="frm-submit-data" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            @if($isEdit)
                                @method('PUT')
                            @endif
                            <div class="headers-line mt-md"><i class="fas fa-user-check"></i> @lang('Teacher Details')</div>
                            <div class="row">
                                <div class="col-md-4 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Staff ID')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            <input type="text" name="staff_id" class="form-control @error('staff_id') is-invalid @enderror" value="{{ old('staff_id', isset($teacher) ? $teacher->staff_id : $generatedStaffId) }}" placeholder="@lang('Staff ID')" readonly>                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Name')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $teacher->name ?? '') }}"  placeholder="@lang('name')">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Gender')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                        <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                            @foreach(['Male', 'Female', 'Other'] as $gender)
                                                <option value="{{ $gender }}" @if(old('gender', $teacher->gender ?? '') == $gender) selected @endif>{{ $gender }}</option>
                                            @endforeach
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Date of Birth')</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob', $teacher->dob ?? '') }}" placeholder="@lang('Enter date of birth')">
                                        </div>
                                    </div>
                                </div>
            
                                <div class="col-md-4 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Phone')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $teacher->phone ?? '') }}" placeholder="@lang('Enter phone')">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Email')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $teacher->email ?? '') }}" placeholder="@lang('Enter email')">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Joining Date')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                            <input type="date" name="joining_date" class="form-control @error('joining_date') is-invalid @enderror" value="{{ old('joining_date', $teacher->joining_date ?? '') }}" placeholder="@lang('Enter Joining Date')">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Blood Group')</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-tint"></i></span>
                                            <input type="text" name="blood_group" class="form-control" value="{{ old('blood_group', $teacher->blood_group ?? '') }}" placeholder="@lang('Enter Blood Group')">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Religion')</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-praying-hands"></i></span>
                                            <input type="text" name="religion" class="form-control" value="{{ old('religion', $teacher->religion ?? '') }}" placeholder="@lang('Enter Religion')"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Marital Status')</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-ring"></i></span>
                                            <input type="text" name="marital_status" class="form-control" value="{{ old('marital_status', $teacher->marital_status ?? '') }}" placeholder="@lang('Enter Marital Status')"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Status')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                                            <select name="status" class="form-control">
                                                <option value="1" @if(old('status', $teacher->status ?? 1) == 1) selected @endif>Active</option>
                                                <option value="0" @if(old('status', $teacher->status ?? 1) == 0) selected @endif>Inactive</option>
                                            </select> 
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Address')</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <textarea name="address" class="form-control">{{ old('address', $teacher->address ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Photo')</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="far fa-image"></i></span>
                                            <input type="file" name="photo" class="form-control">
                                            <!-- @if($isEdit && $teacher->photo)
                                                <img src="{{ asset('storage/' . $teacher->photo) }}" alt="Photo" style="max-width: 150px; margin-top: 10px;">
                                            @endif -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h4>Qualifications <button type="button" id="add-qualification" class="btn btn-success btn-sm mb-3" style="margin-top: 17px;"><i class="fas fa-plus-circle"></i></button></h4>
                            <div id="qualifications-wrapper">
                                @php
                                    $qualifications = old('qualifications', isset($teacher) && $teacher->qualifications ? $teacher->qualifications->toArray() : []);
                                @endphp
                                
                                @foreach($qualifications as $index => $qualification)
                                    <div class="qualification-item border p-3 mb-3">
                                        
                                        <div class="row">
                                            <div class="col-md-2 mb-sm">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('Qualification')<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-certificate"></i></span>
                                                        <input type="text" name="qualifications[{{ $index }}][qualification]" class="form-control @error('qualifications.' . $index . '.qualification') is-invalid @enderror" value="{{ $qualification['qualification'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-sm">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('Specialization')<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-book-open"></i></span>
                                                        <input type="text" name="qualifications[{{ $index }}][specialization]" class="form-control @error('qualifications.' . $index . '.specialization') is-invalid @enderror" value="{{ $qualification['specialization'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-sm">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('University')<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                                                        <input type="text" name="qualifications[{{ $index }}][university]" class="form-control @error('qualifications.' . $index . '.university') is-invalid @enderror" value="{{ $qualification['university'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-sm">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('Passing Year')<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                        <input type="number" name="qualifications[{{ $index }}][passing_year]" class="form-control @error('qualifications.' . $index . '.passing_year') is-invalid @enderror" value="{{ $qualification['passing_year'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-sm">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('Grade')<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-chart-line"></i></span>
                                                        <input type="text" name="qualifications[{{ $index }}][grade]" class="form-control @error('qualifications.' . $index . '.grade') is-invalid @enderror" value="{{ $qualification['grade'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-sm">
                                                <div class="form-group" style="padding-top: 34px;">
                                                    <button type="button" class="btn btn-danger btn-sm mb-2 remove-qualification">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- <button type="button" id="add-qualification" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i></button> -->
                            <hr>
                            <h4>Experiences <button type="button" id="add-experience" class="btn btn-success btn-sm mb-3" style="margin-top: 17px;"><i class="fas fa-plus-circle"></i></button></h4>
                            <div id="experiences-wrapper">
                                @php
                                    $experiences = old('experiences', isset($teacher) && $teacher->experiences ? $teacher->experiences->toArray() : []);
                                @endphp
                                @foreach($experiences as $index => $experience)
                                    <div class="experience-item border p-3 mb-3">
                                        
                                        <div class="row">
                                            <div class="col-md-2 mb-sm">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('School Name')<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-school"></i></span>
                                                        <input type="text" name="experiences[{{ $index }}][school_name]" class="form-control @error('experiences.' . $index . '.school_name') is-invalid @enderror" value="{{ $experience['school_name'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-sm">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('Position')<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                                        <input type="text" name="experiences[{{ $index }}][position]" class="form-control @error('experiences.' . $index . '.position') is-invalid @enderror" value="{{ $experience['position'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-sm">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('From Date')<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                                        <input type="date" name="experiences[{{ $index }}][from_date]" class="form-control @error('experiences.' . $index . '.from_date') is-invalid @enderror" value="{{ $experience['from_date'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-sm">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('To Date')<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                                        <input type="date" name="experiences[{{ $index }}][to_date]" class="form-control @error('experiences.' . $index . '.to_date') is-invalid @enderror" value="{{ $experience['to_date'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-sm">
                                                <div class="form-group">
                                                    <label class="control-label">@lang('Experience Years')<span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                                                        <input type="number" step="0.01" name="experiences[{{ $index }}][experience_years]" class="form-control @error('experiences.' . $index . '.experience_years') is-invalid @enderror" value="{{ $experience['experience_years'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-sm">
                                                <div class="form-group" style="padding-top: 34px;">
                                                    <button type="button" class="btn btn-danger btn-sm mb-2 remove-experience">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing" class="btn btn-sm btn-primary d-feex justify-content-end">
                                <i class="fas fa-plus-circle"></i> @lang('Save')
                            </button>
                        </div>
                    </form>
                     <!-- Templates -->
                    <template id="qualification-template">
                        <div class="qualification-item border p-3 mb-3">
                            
                            <div class="row">
                                <div class="col-md-2 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Qualification')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-certificate"></i></span>
                                            <input type="text" name="qualification_placeholder[qualification]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Specialization')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-book-open"></i></span>
                                            <input type="text" name="qualification_placeholder[specialization]" class="form-control">                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('University')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-university"></i></span>
                                            <input type="text" name="qualification_placeholder[university]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Passing Year')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="number" name="qualification_placeholder[passing_year]" class="form-control">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Grade')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-chart-line"></i></span>
                                            <input type="text" name="qualification_placeholder[grade]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-sm">
                                    <div class="form-group" style="padding-top: 34px;">
                                        <button type="button" class="btn btn-danger btn-sm mb-2 remove-qualification">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template id="experience-template">
                        <div class="experience-item border p-3 mb-3">
                            <div class="row">
                            <div class="col-md-2 mb-sm">
                                <div class="form-group">
                                        <label class="control-label">@lang('School Name')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-school"></i></span>
                                            <input type="text" name="experience_placeholder[school_name]" class="form-control">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Position')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                            <input type="text" name="experience_placeholder[position]" class="form-control">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('From Date')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-day"></i></span>
                                            <input type="date" name="experience_placeholder[from_date]" class="form-control">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('To Date')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                            <input type="date" name="experience_placeholder[to_date]" class="form-control">
                                        </div>
                        
                                    </div>
                                </div>
                                <div class="col-md-2 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Experience Years')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-hourglass-half"></i></span>
                                            <input type="number" step="0.01" name="experience_placeholder[experience_years]" class="form-control">
                                        </div>
                                        @error('') <span class="text-danger">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-2 mb-sm">
                                    <div class="form-group" style="padding-top: 34px;">
                                        <button type="button" class="btn btn-danger btn-sm mb-2 remove-experience">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let qualificationIndex = {{ count($qualifications) }};
    let experienceIndex = {{ count($experiences) }};

    document.getElementById('add-qualification').addEventListener('click', function () {
        let template = document.getElementById('qualification-template').innerHTML;
        let html = template.replace(/qualification_placeholder/g, `qualifications[${qualificationIndex}]`);
        document.getElementById('qualifications-wrapper').insertAdjacentHTML('beforeend', html);
        qualificationIndex++;
        attachRemoveHandlers();
    });

    document.getElementById('add-experience').addEventListener('click', function () {
        let template = document.getElementById('experience-template').innerHTML;
        let html = template.replace(/experience_placeholder/g, `experiences[${experienceIndex}]`);
        document.getElementById('experiences-wrapper').insertAdjacentHTML('beforeend', html);
        experienceIndex++;
        attachRemoveHandlers();
    });

    function attachRemoveHandlers() {
        document.querySelectorAll('.remove-qualification').forEach(btn => {
            btn.onclick = () => btn.closest('.qualification-item').remove();
        });
        document.querySelectorAll('.remove-experience').forEach(btn => {
            btn.onclick = () => btn.closest('.experience-item').remove();
        });
    }

    attachRemoveHandlers();
});
</script>
@endsection