@extends('admin.layouts.app')
@section('styles')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
@section('panel')
<section class="content">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">{{ $teacher->name }} @lang('Teacher Details')</h3>
            <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> @lang('Back to List')
            </a>
        </div>

        <div class="card">
            <div class="card-body">

                {{-- Nav Tabs --}}
                <ul class="nav nav-tabs" id="teacherTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">@lang('Info')</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#qualifications" type="button" role="tab">@lang('Qualifications')</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#experiences" type="button" role="tab">@lang('Experiences')</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#assine_class_subject" type="button" role="tab">@lang('Assign class & subject')</button>
                    </li>
                </ul>

                {{-- Tab Content --}}
                <div class="tab-content mt-3" id="teacherTabContent">

                    {{-- Info Tab --}}
                    <div class="tab-pane fade show active" id="info" role="tabpanel">
                        <div class="row">
                            @foreach ([
                                'Staff ID' => $teacher->staff_id,
                                'Name' => $teacher->name,
                                'Gender' => $teacher->gender,
                                'Phone' => $teacher->phone,
                                'Email' => $teacher->email,
                                'Joining Date' => showDateTime($teacher->joining_date),
                                'Blood Group' => $teacher->blood_group,
                                'Religion' => $teacher->religion,
                                'Marital Status' => $teacher->marital_status,
                                'Address' => $teacher->address,
                            ] as $label => $value)
                                <div class="col-md-4 mb-2">
                                    <strong>@lang($label):</strong> {{ $value }}
                                </div>
                            @endforeach
                            <div class="col-md-4 mb-2">
                                <strong>@lang('Status'):</strong>
                                <span class="badge {{ $teacher->status ? 'bg-success' : 'bg-danger' }}">
                                    {{ $teacher->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                            @if($teacher->photo)
                                <div class="col-md-4 mt-2">
                                    <strong>@lang('Photo'):</strong><br>
                                    <img src="{{ asset('storage/' . $teacher->photo) }}" alt="Photo" class="img-thumbnail mt-2" style="max-width: 150px;">
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Qualifications Tab --}}
                    <div class="tab-pane fade" id="qualifications" role="tabpanel">
                        @if($teacher->qualifications->isEmpty())
                            <p class="text-muted">@lang('No qualifications found.')</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>@lang('Qualification')</th>
                                            <th>@lang('Specialization')</th>
                                            <th>@lang('University')</th>
                                            <th>@lang('Passing Year')</th>
                                            <th>@lang('Grade')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($teacher->qualifications as $q)
                                            <tr>
                                                <td>{{ $q->qualification }}</td>
                                                <td>{{ $q->specialization }}</td>
                                                <td>{{ $q->university }}</td>
                                                <td>{{ $q->passing_year }}</td>
                                                <td>{{ $q->grade }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    {{-- Experiences Tab --}}
                    <div class="tab-pane fade" id="experiences" role="tabpanel">
                        @if($teacher->experiences->isEmpty())
                            <p class="text-muted">@lang('No experiences found.')</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>@lang('School Name')</th>
                                            <th>@lang('Position')</th>
                                            <th>@lang('From')</th>
                                            <th>@lang('To')</th>
                                            <th>@lang('Experience Years')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($teacher->experiences as $e)
                                            <tr>
                                                <td>{{ $e->school_name }}</td>
                                                <td>{{ $e->position }}</td>
                                                <td>{{ showDateTime($e->from_date) }}</td>
                                                <td>{{ showDateTime($e->to_date) }}</td>
                                                <td>{{ fmod($e->experience_years, 1) == 0 ? number_format($e->experience_years, 0) : number_format($e->experience_years, 1) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                    {{-- Assign class & subject --}}
                    <div class="tab-pane fade" id="assine_class_subject" role="tabpanel">
                        @if($teacher->classSubjects->isEmpty())
                            <p class="text-muted">@lang('No experiences found.')</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>@lang('Class')</th>
                                            <th>@lang('Section')</th>
                                            <th>@lang('Subjects')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Loop grouped by class & section --}}
                                        @php
                                            $grouped = $teacher->classSubjects->groupBy(function($item) {
                                                return $item->class_id . '-' . $item->section_id;
                                            });
                                        @endphp
                                        @foreach($grouped as $group)
                                            @php
                                                $first = $group->first();
                                                $class = $first->class->name ?? '-';
                                                $section = $first->section->name ?? '-';
                                            @endphp
                                            <tr>
                                                <td><span class="badge bg-info">{{ $class }}</span></td>
                                                <td><span class="badge bg-warning">{{ $section }}</span></td>
                                                <td>
                                                    @foreach($group->pluck('subject.name')->unique() as $subjectName)
                                                        <span class="badge bg-secondary">{{ $subjectName }}</span>
                                                    @endforeach
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
