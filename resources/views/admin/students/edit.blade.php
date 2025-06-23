@extends('admin.layouts.app')
@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="fas fa-graduation-cap"></i></i> @lang('Student Admission Edit')</h3>
                    </div>
                    <form action="{{ route('admin.students.update', $enrollment->id) }}" class="frm-submit-data" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            @csrf
                            @method('PUT')
                            <div class="headers-line mt-md"><i class="fas fa-user-check"></i> @lang('Student Details')</div>
                            <div class="row">
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Academic Year')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <select name="year_id" class="form-control" data-plugin-selecttwo="" id="year_id" style="{{ isset($enrollment->student->detail->aadhaar_number) && $enrollment->student->detail->aadhaar_number ? 'pointer-events:none;' : '' }}" tabindex="-1" aria-hidden="true">
                                                <option value="" selected="selected">@lang('Select Academic Year')</option>
                                                @foreach ($sessions as $session)
                                                    <option value="{{ $session->id }}" {{ old('year_id',$enrollment->session_id) == $session->id ? 'selected' : '' }}>{{ $session->session }}</option>
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
                                            <input type="text" name="student_name" value="{{ old('student_name', $enrollment->student->student_name) }}" class="form-control @error('student_name') is-invalid @enderror" required>
                                        </div>
                                        @error('student_name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Date of Birth')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            <input type="date" name="dob" value="{{ old('dob', $enrollment->student->dob) }}" class="form-control @error('dob') is-invalid @enderror" required>
                                        </div>
                                        @error('dob') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Gender')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                            <select name="gender" class="form-control @error('gender') is-invalid @enderror" required>
                                                <option value="male" {{ old('gender', $enrollment->student->gender) == 'male' ? 'selected' : '' }}>@lang('Male')</option>
                                                <option value="female" {{ old('gender', $enrollment->student->gender) == 'female' ? 'selected' : '' }}>@lang('Female')</option>
                                            </select>
                                        </div>
                                        @error('gender') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Caste/Category')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                            <select name="caste" class="form-control @error('caste') is-invalid @enderror" required>
                                                <option value="">@lang('Select Category')</option>
                                                <option value="1" {{ old('caste', $enrollment->student->caste) == 1 ? 'selected' : '' }}>@lang('General')</option>
                                                <option value="2" {{ old('caste', $enrollment->student->caste) == 2 ? 'selected' : '' }}>@lang('Science')</option>
                                                <option value="3" {{ old('caste', $enrollment->student->caste) == 3 ? 'selected' : '' }}>@lang('Commerce')</option>
                                            </select>
                                        </div>
                                        @error('caste') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Class')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-chalkboard"></i></span>
                                            <select name="class_id" id="class_id" class="form-control @error('class_id') is-invalid @enderror" style="{{ isset($enrollment->student->detail->aadhaar_number) && $enrollment->student->detail->aadhaar_number ? 'pointer-events:none;' : '' }}" required>
                                                <option value="" selected="selected">@lang('Select Class')</option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}" {{ old('class_id', $enrollment->class_id) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
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
                                            <select name="section_id" class="form-control" data-plugin-selecttwo="" id="section_id" style="{{ isset($enrollment->student->detail->aadhaar_number) && $enrollment->student->detail->aadhaar_number ? 'pointer-events:none;' : '' }}" tabindex="-1" >
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
                                            <input type="text" name="roll_no" value="{{ old('roll_no',$enrollment->roll_no) }}" class="form-control" placeholder="@lang('Enter roll no')" >
                                        </div>
                                        @error('roll_no') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label for="photo">@lang('Student Photo')</label>
                                        <div class="input-group">
                                            <input type="file" name="photo" id="photo" class="form-control" >
                                        </div>
                                        @error('photo') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label for="photo">@lang('Student Photo')</span></label>
                                        <div class="input-group">
                                            <img src="{{ $enrollment->student->photo ? asset('storage/' . $enrollment->student->photo) : asset('admin/images/user.png') }}" alt="@lang('Student Photo')" class="" width="120" height="100">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="headers-line  mt-md"><i class="fas fa-user-check"></i> @lang('Student Other Details')</div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label>@lang('Student AADHAAR Number')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            <input type="text" name="aadhaar_number" class="form-control @error('aadhaar_number') is-invalid @enderror" value="{{ old('aadhaar_number', $enrollment->student->detail->aadhaar_number ?? '') }}">
                                        </div>
                                        @error('aadhaar_number') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Religion')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-praying-hands"></i></span>
                                            <select name="religion" class="form-control @error('religion') is-invalid @enderror" required>
                                                <option value="">@lang('Select religion')</option>
                                                <option value="1" {{ old('religion', $enrollment->student->detail->religion ?? '') == 1 ? 'selected' : '' }}>@lang('Hindu')</option>
                                                <option value="2" {{ old('religion', $enrollment->student->detail->religion ?? '') == 2 ? 'selected' : '' }}>@lang('Muslim')</option>
                                                <option value="3" {{ old('religion', $enrollment->student->detail->religion ?? '') == 3 ? 'selected' : '' }}>@lang('Christian')</option>
                                                <option value="4" {{ old('religion', $enrollment->student->detail->religion ?? '') == 4 ? 'selected' : '' }}>@lang('Sikh')</option>
                                                <option value="5" {{ old('religion', $enrollment->student->detail->religion ?? '') == 5 ? 'selected' : '' }}>@lang('Buddhist')</option>
                                                <option value="6" {{ old('religion', $enrollment->student->detail->religion ?? '') == 6 ? 'selected' : '' }}>@lang('Other')</option>
                                            </select>
                                        </div>
                                        @error('religion') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Mother Tongue')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-language"></i></span>
                                            <select name="mother_tongue" class="form-control @error('mother_tongue') is-invalid @enderror" required>
                                                <option value="">@lang('Select mother tongue')</option>
                                                <option value="1" {{ old('mother_tongue', $enrollment->student->detail->mother_tongue ?? '') == 1 ? 'selected' : '' }}>@lang('Hindi')</option>
                                                <option value="2" {{ old('mother_tongue', $enrollment->student->detail->mother_tongue ?? '') == 2 ? 'selected' : '' }}>@lang('English')</option>
                                                <option value="3" {{ old('mother_tongue', $enrollment->student->detail->mother_tongue ?? '') == 3 ? 'selected' : '' }}>@lang('Gujarati')</option>
                                                <option value="4" {{ old('mother_tongue', $enrollment->student->detail->mother_tongue ?? '') == 4 ? 'selected' : '' }}>@lang('Marathi')</option>
                                                <option value="5" {{ old('mother_tongue', $enrollment->student->detail->mother_tongue ?? '') == 5 ? 'selected' : '' }}>@lang('Urdu')</option>
                                                <option value="6" {{ old('mother_tongue', $enrollment->student->detail->mother_tongue ?? '') == 6 ? 'selected' : '' }}>@lang('Other')</option>
                                            </select>
                                        </div>
                                        @error('mother_tongue') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label>@lang('Jan Aadhar No.')</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                                            <input type="text" name="jan_aadhar_no" class="form-control @error('jan_aadhar_no') is-invalid @enderror" value="{{ old('jan_aadhar_no', $enrollment->student->detail->jan_aadhar_no ?? '') }}">
                                        </div>
                                        @error('jan_aadhar_no') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Rural/Urban')</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-city"></i></span>
                                            <select name="rural_urban" class="form-control @error('rural_urban') is-invalid @enderror">
                                                <option value="">@lang('Select Rural/Urban')</option>
                                                <option value="Rural" {{ old('rural_urban', $enrollment->student->detail->rural_urban ?? '') == 'Rural' ? 'selected' : '' }}>@lang('Rural')</option>
                                                <option value="Urban" {{ old('rural_urban', $enrollment->student->detail->rural_urban ?? '') == 'Urban' ? 'selected' : '' }}>@lang('Urban')</option>
                                            </select>
                                        </div>
                                        @error('rural_urban') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label>@lang('Name of Habitation / Locality')</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <input type="text" name="habitation" class="form-control @error('habitation') is-invalid @enderror" value="{{ old('habitation', $enrollment->student->detail->habitation ?? '') }}">
                                        </div>
                                        @error('habitation') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Date of Admission')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                            <input type="date" name="date_of_admission" class="form-control @error('date_of_admission') is-invalid @enderror" value="{{ old('date_of_admission', $enrollment->student->detail->date_of_admission ?? '') }}">
                                        </div>
                                        @error('date_of_admission') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label>@lang('Admission No / SR No')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            <input type="text" name="admission_no" class="form-control @error('admission_no') is-invalid @enderror" value="{{ old('admission_no', $enrollment->student->detail->admission_no ?? '') }}">
                                        </div>
                                        @error('admission_no') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label>@lang('Whether belong to Below Poverty Line')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                            <select name="bpl" class="form-control @error('bpl') is-invalid @enderror">
                                                <option value="">--@lang('Select')--</option>
                                                <option value="1" {{ old('bpl', $enrollment->student->detail->bpl ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('bpl', $enrollment->student->detail->bpl ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('bpl') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label>@lang('Disadvantage Group /Weaker Section')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-users"></i></span>
                                            <select name="weaker_section" class="form-control @error('weaker_section') is-invalid @enderror">
                                                <option value="">--@lang('Select')--</option>
                                                <option value="1" {{ old('weaker_section', $enrollment->student->detail->weaker_section ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('weaker_section', $enrollment->student->detail->weaker_section ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('weaker_section') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label>@lang('Getting free education as per RTE Act')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-book-open"></i></span>
                                            <select name="rte_education" class="form-control @error('rte_education') is-invalid @enderror">
                                                <option value="">--@lang('Select')--</option>
                                                <option value="1" {{ old('rte_education', $enrollment->student->detail->rte_education ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('rte_education', $enrollment->student->detail->rte_education ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('rte_education') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>@lang('Class studied previous year')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-book-reader"></i></span>
                                            <select name="class_studied_previous_year" class="form-control @error('class_studied_previous_year') is-invalid @enderror">
                                                <option value="">@lang('Select')</option>
                                                <option value="first" {{ old('class_studied_previous_year', $enrollment->student->detail->class_studied_previous_year ?? '') == 'first' ? 'selected' : '' }}>@lang('First')</option>
                                                <option value="second" {{ old('class_studied_previous_year', $enrollment->student->detail->class_studied_previous_year ?? '') == 'second' ? 'selected' : '' }}>@lang('Second')</option>
                                            </select>
                                        </div>
                                        @error('class_studied_previous_year') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>@lang('If studying in class-1st, give status')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-school"></i></span>
                                            <select name="status_if_class_1st" class="form-control @error('status_if_class_1st') is-invalid @enderror">
                                                <option value="">@lang('Select')</option>
                                                <option value="same_school" {{ old('status_if_class_1st', $enrollment->student->detail->status_if_class_1st ?? '') == 'same_school' ? 'selected' : '' }}>@lang('SAME SCHOOL')</option>
                                                <option value="other" {{ old('status_if_class_1st', $enrollment->student->detail->status_if_class_1st ?? '') == 'other' ? 'selected' : '' }}>@lang('OTHER')</option>
                                            </select>
                                        </div>
                                        @error('status_if_class_1st') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>                                

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label>@lang('No. of days child attended school in previous year')</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                            <input type="text" name="attended_school" class="form-control @error('attended_school') is-invalid @enderror" value="{{ old('attended_school', $enrollment->student->detail->attended_school ?? '') }}">
                                        </div>
                                        @error('attended_school') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>                                
                            
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label>@lang('Medium of instruction')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-wallet"></i></span>
                                            <select name="medium" class="form-control @error('medium') is-invalid @enderror">
                                                <option value="">@lang('Select')</option>
                                                @foreach(['english', 'hindi', 'gujarati', 'marathi', 'urdu', 'other'] as $lang)
                                                    <option value="{{ $lang }}" {{ old('medium', $enrollment->student->detail->medium ?? '') == $lang ? 'selected' : '' }}>@lang(ucfirst($lang))</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('medium') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="disability_type">@lang('Type of Disability') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-wheelchair"></i></span>
                                            <select name="disability_type" id="disability_type" class="form-control @error('disability_type') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                @foreach(['none', 'visual', 'hearing', 'speech', 'locomotor', 'learning', 'multiple', 'other'] as $type)
                                                    <option value="{{ $type }}" {{ old('disability_type', $enrollment->student->detail->disability_type ?? '') == $type ? 'selected' : '' }}>@lang(ucwords(str_replace('_', ' ', $type)))</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('disability_type') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="cwsn_facility">@lang('Facilities provided to CWSN') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-wheelchair"></i></span>
                                            <select name="cwsn_facility" id="cwsn_facility" class="form-control @error('cwsn_facility') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                @foreach(['escort', 'reader', 'device', 'transport', 'scholarship', 'other', 'none'] as $facility)
                                                    <option value="{{ $facility }}" {{ old('cwsn_facility', $enrollment->student->detail->cwsn_facility ?? '') == $facility ? 'selected' : '' }}>@lang(ucwords(str_replace('_', ' ', $facility)))</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('cwsn_facility') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="uniforms">@lang('No. of uniform sets received') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-tshirt"></i></span>
                                            <select name="uniforms" id="uniforms" class="form-control @error('uniforms') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                @foreach([0, 1, 2] as $uniform)
                                                    <option value="{{ $uniform }}" {{ old('uniforms', $enrollment->student->detail->uniforms ?? '') == $uniform ? 'selected' : '' }}>{{ $uniform }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('uniforms') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="textbook">@lang('Complete set of free Textbook') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-book"></i></span>
                                            <select name="textbook" id="textbook" class="form-control @error('textbook') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('textbook', $enrollment->student->detail->textbook ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('textbook', $enrollment->student->detail->textbook ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('textbook') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="midday_meal">@lang('Whether the child is Mid-day Meal beneficiary') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-utensils"></i></span>
                                            <select name="midday_meal" id="midday_meal" class="form-control @error('midday_meal') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('midday_meal', $enrollment->student->detail->midday_meal ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('midday_meal', $enrollment->student->detail->midday_meal ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('midday_meal') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>                                                              

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="hostel_facility">@lang('Free Hostel facility') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-bed"></i></span>
                                            <select name="hostel_facility" id="hostel_facility" class="form-control @error('hostel_facility') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('hostel_facility', $enrollment->student->detail->hostel_facility ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('hostel_facility', $enrollment->student->detail->hostel_facility ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('hostel_facility') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="special_training">@lang('Whether child attended Special training') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-chalkboard-teacher"></i></span>
                                            <select name="special_training" id="special_training" class="form-control @error('special_training') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('special_training', $enrollment->student->detail->special_training ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('special_training', $enrollment->student->detail->special_training ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('special_training') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="homeless_status">@lang('Whether the child is homeless') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-house-damage"></i></span>
                                            <select name="homeless_status" id="homeless_status" class="form-control @error('homeless_status') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('homeless_status', $enrollment->student->detail->homeless_status ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('homeless_status', $enrollment->student->detail->homeless_status ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('homeless_status') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="appeared_last_exam">@lang('Appeared in the last year annual examination') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-pen"></i></span>
                                            <select name="appeared_last_exam" id="appeared_last_exam" class="form-control @error('appeared_last_exam') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('appeared_last_exam', $enrollment->student->detail->appeared_last_exam ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('appeared_last_exam', $enrollment->student->detail->appeared_last_exam ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('appeared_last_exam') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="passed_last_exam">@lang('Passed in the last year annual examination') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                                            <select name="passed_last_exam" id="passed_last_exam" class="form-control @error('passed_last_exam') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('passed_last_exam', $enrollment->student->detail->passed_last_exam ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('passed_last_exam', $enrollment->student->detail->passed_last_exam ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('passed_last_exam') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>                                                               

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="last_exam_percentage">@lang('% Marks obtained in last year annual exam(if available)')</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-percent"></i></span>
                                            <input type="text" name="last_exam_percentage" class="form-control @error('last_exam_percentage') is-invalid @enderror" value="{{ old('last_exam_percentage', $enrollment->student->detail->last_exam_percentage ?? '') }}">
                                        </div>
                                        @error('last_exam_percentage') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>                                

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="stream">@lang('Stream(grades 11 & 12)') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                            <select name="stream" id="stream" class="form-control @error('stream') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="science" {{ old('stream', $enrollment->student->detail->stream ?? '') == 'science' ? 'selected' : '' }}>@lang('Science')</option>
                                                <option value="commerce" {{ old('stream', $enrollment->student->detail->stream ?? '') == 'commerce' ? 'selected' : '' }}>@lang('Commerce')</option>
                                                <option value="arts" {{ old('stream', $enrollment->student->detail->stream ?? '') == 'arts' ? 'selected' : '' }}>@lang('Arts')</option>
                                                <option value="other" {{ old('stream', $enrollment->student->detail->stream ?? '') == 'other' ? 'selected' : '' }}>@lang('Other')</option>
                                            </select>
                                        </div>
                                        @error('stream') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>                                

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="trade_sector">@lang('Trade/Sector(grades 9 & 12)') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-tools"></i></span>
                                            <select name="trade_sector" id="trade_sector" class="form-control @error('trade_sector') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="automotive" {{ old('trade_sector', $enrollment->student->detail->trade_sector ?? '') == 'automotive' ? 'selected' : '' }}>@lang('Automotive')</option>
                                                <option value="carpentry" {{ old('trade_sector', $enrollment->student->detail->trade_sector ?? '') == 'carpentry' ? 'selected' : '' }}>@lang('Carpentry')</option>
                                                <option value="electronics" {{ old('trade_sector', $enrollment->student->detail->trade_sector ?? '') == 'electronics' ? 'selected' : '' }}>@lang('Electronics')</option>
                                                <option value="plumbing" {{ old('trade_sector', $enrollment->student->detail->trade_sector ?? '') == 'plumbing' ? 'selected' : '' }}>@lang('Plumbing')</option>
                                                <option value="welding" {{ old('trade_sector', $enrollment->student->detail->trade_sector ?? '') == 'welding' ? 'selected' : '' }}>@lang('Welding')</option>
                                                <option value="other" {{ old('trade_sector', $enrollment->student->detail->trade_sector ?? '') == 'other' ? 'selected' : '' }}>@lang('Other')</option>
                                            </select>
                                        </div>
                                        @error('trade_sector') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>                                

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="iron_folic_tablets">@lang('Tablets Received Iron & Folic acid') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-capsules"></i></span>
                                            <select name="iron_folic_tablets" id="iron_folic_tablets" class="form-control @error('iron_folic_tablets') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('iron_folic_tablets', $enrollment->student->detail->iron_folic_tablets ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('iron_folic_tablets', $enrollment->student->detail->iron_folic_tablets ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('iron_folic_tablets') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>                                

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="deworming_tablets">@lang('Tablets Received of Deworming') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-pills"></i></span>
                                            <select name="deworming_tablets" id="deworming_tablets" class="form-control @error('deworming_tablets') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('deworming_tablets', $enrollment->student->detail->deworming_tablets ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('deworming_tablets', $enrollment->student->detail->deworming_tablets ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('deworming_tablets') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>                                

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="vitamin_a_tablets">@lang('Tablets Received Vitamin-A supplement') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-tablets"></i></span>
                                            <select name="vitamin_a_tablets" id="vitamin_a_tablets" class="form-control @error('vitamin_a_tablets') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('vitamin_a_tablets', $enrollment->student->detail->vitamin_a_tablets ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('vitamin_a_tablets', $enrollment->student->detail->vitamin_a_tablets ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('vitamin_a_tablets') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>                                

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="mobile">@lang('Mobile Number')</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                            <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile', $enrollment->student->detail->mobile ?? '') }}">
                                        </div>
                                        @error('mobile') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="email">@lang('Email Address')</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $enrollment->student->detail->email ?? '') }}">
                                        </div>
                                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="transport">@lang('Free Transport facility') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-bus"></i></span>
                                            <select name="transport" id="transport" class="form-control @error('transport') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('transport', $enrollment->student->detail->transport ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('transport', $enrollment->student->detail->transport ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('transport') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="bicycle">@lang('Free Bicycle facility') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-bicycle"></i></span>
                                            <select name="bicycle" id="bicycle" class="form-control @error('bicycle') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('bicycle', $enrollment->student->detail->bicycle ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('bicycle', $enrollment->student->detail->bicycle ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('bicycle') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label for="escort_facility">@lang('Free Escort facility') <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                            <select name="escort_facility" id="escort_facility" class="form-control @error('escort_facility') is-invalid @enderror" required>
                                                <option value="">@lang('Select')</option>
                                                <option value="1" {{ old('escort_facility', $enrollment->student->detail->escort_facility ?? '') == 1 ? 'selected' : '' }}>@lang('Yes')</option>
                                                <option value="2" {{ old('escort_facility', $enrollment->student->detail->escort_facility ?? '') == 2 ? 'selected' : '' }}>@lang('No')</option>
                                            </select>
                                        </div>
                                        @error('escort_facility') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Transport Route')</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-bus"></i></span>
                                            <select name="route_id" class="form-control @error('route_id') is-invalid @enderror" id="route_id" data-plugin-selecttwo="" data-width="100%" tabindex="-1" aria-hidden="true">
                                                <option value="" selected="selected">@lang('Select')</option>
                                                @foreach ($transports as $transport)
                                                    <option value="{{ $transport->id }}" {{ old('route_id', $enrollment->route_id) == $transport->id ? 'selected' : '' }}>{{ $transport->route_name }} (@lang('Start'): {{ $transport->start_place }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="headers-line  mt-md"><i class="fas fa-user-tie"></i> @lang('Guardian Details')</div>
                                </div>

                                <div class="col-md-12 mb-sm checkbox-replace">
                                    <label class="i-checks">
                                        <input type="checkbox" name="guardian_chk" id="chkGuardian" value="true"><i></i> 
                                        @lang('Guardian Already Exist')					
                                    </label>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Father`s Name')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="father_name" value="{{ old('father_name', $enrollment->student->father_name) }}" class="form-control @error('father_name') is-invalid @enderror" required>
                                        </div>
                                        @error('father_name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Mother`s Name')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="mother_name" value="{{ old('mother_name', $enrollment->student->mother_name) }}" class="form-control @error('mother_name') is-invalid @enderror" required>
                                        </div>
                                        @error('mother_name') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div> 

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Guardian Mobile')<span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone-volume"></i></span>
                                            <input type="text" name="guardian_mobile" value="{{ old('guardian_mobile', $enrollment->student->guardian_mobile) }}" class="form-control @error('guardian_mobile') is-invalid @enderror" required>
                                        </div>
                                        @error('guardian_mobile') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Relation') <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('grd_relation') is-invalid @enderror" name="grd_relation" value="{{ old('grd_relation', $enrollment->student->guardianDetail->grd_relation ?? '') }}">
                                        @error('grd_relation') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Occupation') <span class="text-danger">*</span></label>
                                        <input class="form-control @error('grd_occupation') is-invalid @enderror" name="grd_occupation" value="{{ old('grd_occupation', $enrollment->student->guardianDetail->grd_occupation ?? '') }}" type="text">
                                        @error('grd_occupation') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Income') <span class="text-danger">*</span></label>
                                        <input class="form-control @error('grd_income') is-invalid @enderror" name="grd_income" value="{{ old('grd_income', $enrollment->student->guardianDetail->grd_income ?? '') }}" type="text">
                                        @error('grd_income') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Education') <span class="text-danger">*</span></label>
                                        <input class="form-control @error('grd_education') is-invalid @enderror" name="grd_education" value="{{ old('grd_education', $enrollment->student->guardianDetail->grd_education ?? '') }}" type="text">
                                        @error('grd_education') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('City')</label>
                                        <input class="form-control @error('grd_city') is-invalid @enderror" name="grd_city" value="{{ old('grd_city', $enrollment->student->guardianDetail->grd_city ?? '') }}" type="text">
                                        @error('grd_city') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('State')</label>
                                        <input class="form-control  @error('grd_state') is-invalid @enderror" name="grd_state" value="{{ old('grd_state', $enrollment->student->guardianDetail->grd_state ?? '') }}" type="text">
                                        @error('grd_state') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Email')</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="far fa-envelope-open"></i></span>
                                            <input type="email" class="form-control @error('grd_email') is-invalid @enderror" name="grd_email" id="grd_email" value="{{ old('grd_email', $enrollment->student->guardianDetail->grd_email ?? '') }}">
                                        </div>
                                        @error('grd_email') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 mb-sm">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Address') <span class="text-danger">*</span></label>
                                        <textarea name="grd_address" rows="2" class="form-control @error('grd_address') is-invalid @enderror" aria-required="true">{{ old('grd_address', $enrollment->student->guardianDetail->grd_address ?? '') }}</textarea>
                                        @error('grd_address') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing" class="btn btn-primary d-feex justify-content-end">
                                <i class="fas fa-plus-circle"></i> @lang('Update')
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
    $('#class_id').on('change', function() {
        var classId = $(this).val();
        var selectedSectionId = "{{ $enrollment->section_id ?? '' }}";
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