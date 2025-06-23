@extends('admin.layouts.app')
@section('styles')
    <style>
        .profile-head {
            padding: 30px 0;
            border-radius: 8px;
            position: relative;
            background-image: url(../images/profile_bg.jpg);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            overflow: hidden;
            color: #fff;
        }
        .profile-head::before {
            content: "";
            position: absolute;
            height: 100%;
            width: 80%;
            background: #c866a1;
            opacity: .40;
            top: 0;
            left: -20%;
            transform: skewX(30deg);
        }
        .image-content-center.user-pro {
            height: 334px;
            max-width: 90%;
            margin: 0 auto;
            border-color: rgba(255, 255, 255, 0.101);
            background-color: rgba(127, 129, 131, 0.501) !important;
            box-shadow: 5px 5px 10px 0 #624949;
        }
        .image-content-center {
            display: block;
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 100%;
            padding: 5px 10px;
            font-size: 14px;
            line-height: 22px;
            border: 1px solid #E5E5E5;
            background: #fbfbfb;
            border-radius: 5px;
        }
        .profile-head ul li .icon-holder {
            display: inline-block;
            height: 27px;
            width: 27px;
            line-height: 62px;
            text-align: center;
            background: transparent;
            border-radius: 15px;
            transform: rotate(0deg);
            z-index: 1;
            margin-right: 10px;
        }
    </style>
@endsection
@section('panel')
@php $castes = [ 1 => 'General',  2 => 'Science',  3 => 'Commerce', ];
    $genders = ['male' => 'Male', 'female' => 'Female'];
    $motherTongues = [ '1' => 'Hindi', '2' => 'English', '3' => 'Gujarati', '4' => 'Marathi', '5' => 'Urdu', '6' => 'Other' ];
    $religions = [ '1' => 'Hindu', '2' => 'Muslim', '3' => 'Christian', '4' => 'Sikh', '5' => 'Buddhist', '6' => 'Other' ];
@endphp
<section class="content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3"><p></p>
            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> @lang('Back')
            </a>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card always-open">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0"><i class="fas fa-user-circle"></i> @lang('Student Profile')</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="profile-head row">
                            <div class="col-md-12 col-lg-4 col-xl-3">
                                <div class="image-content-center user-pro">
                                    <div class="preview">
                                        <img src="{{ $enrollment->photo ? asset('storage/' . $enrollment->photo) : asset('admin/images/user.png') }}" width="334" height="334">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-5 col-xl-5">
                                <h5>{{ $enrollment->student_name }}</h5>
                                <p>@lang('Student') / {{ $castes[$enrollment->student->caste] ?? 'Not Specified' }}</p>
                                <ul class="navbar-nav">
                                    <li class="nav-item d-none d-sm-inline-block"><div class="icon-holder" data-toggle="tooltip" data-original-title="Guardian Name"><i class="fas fa-users"></i></div> {{ $enrollment->student->guardianDetail->father_name }}</li>
                                    <li class="nav-item d-none d-sm-inline-block"><div class="icon-holder" data-toggle="tooltip" data-original-title="Date Of Birth"><i class="fas fa-birthday-cake"></i></div>{{ \Carbon\Carbon::parse($enrollment->dob)->format('d.M.Y') }}</li>
                                    <li class="nav-item d-none d-sm-inline-block"><div class="icon-holder" data-toggle="tooltip" data-original-title="Class"><i class="fas fa-school"></i></div> {{ $enrollment->class->name }} ({{ $enrollment->enrollment->section->name??'N/A' }})</li>
                                    <li class="nav-item d-none d-sm-inline-block"><div class="icon-holder" data-toggle="tooltip" data-original-title="Mobile No"><i class="fas fa-phone-volume"></i></div> {{ $enrollment->student->guardianDetail->guardian_mobile }}</li>
                                    <li class="nav-item d-none d-sm-inline-block"><div class="icon-holder" data-toggle="tooltip" data-original-title="Email"><i class="far fa-envelope"></i></div> {{ $enrollment->student->detail->email ?? 'N/A' }}</li>
                                    <li class="nav-item d-none d-sm-inline-block"><div class="icon-holder" data-toggle="tooltip" data-original-title="Present Address"><i class="fas fa-home"></i></div> {{ $enrollment->student->guardianDetail->grd_address }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user-edit"></i> @lang('Basic Details')</h3>
            
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Expand">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <table class="table table-striped table-bordered table-condensed mb-none">
                            <tbody>
                                <tr>
                                    <th>@lang('Academic Year')</th>
                                    <td>{{ $enrollment->academicSession->session }}</td>
                                    <th>@lang('Admission No')</th>
                                    <td>{{ $enrollment->student->detail->admission_no }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Roll')</th>
                                    <td>{{ $enrollment->roll_no }}</td>
                                    <th>@lang('Admission Date')</th>
                                    <td>{{ $enrollment->student->detail->date_of_admission }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Class')</th>
                                    <td>{{ $enrollment->class->name }}</td>
                                    <th>@lang('Section')</th>
                                    <td>{{ $enrollment->section->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Category')</th>
                                    <td>{{ $castes[$enrollment->student->caste] ?? 'N/A' }}</td>
                                    <th>@lang('Student Name')</th>
                                    <td>{{ $enrollment->student->student_name }} </td>
                                </tr>
                                <tr>
                                    <th>@lang('Gender')</th>
                                    <td>{{ $genders[$enrollment->student->gender] ?? 'N/A' }}</td>
                                    <th>@lang('Date Of Birth')</th>
                                    <td >{{ \Carbon\Carbon::parse($enrollment->student->dob)->format('d.M.Y') }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Mother Tongue')</th>
                                    <td>{{ $motherTongues[$enrollment->student->detail->mother_tongue] ?? 'Not Specified' }}</td>
                                    <th>@lang('Religion')</th>
                                    <td>{{ $religions[$enrollment->student->religion] ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-money-check-alt"></i> @lang('Fees')</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Expand">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        {{-- Summary Row --}}
                        @php
                            $totalCharges = $enrollment->total_fee;
                            $pendingAmount = $enrollment->pending_fee;
                            $totalDeposits = $totalCharges - $pendingAmount;
                        @endphp
                        <div class="row mb-4 text-center">
                            <div class="col-md-4">
                                <div class="bg-primary text-white p-2 rounded">
                                    <strong>@lang('Total Charges')</strong><br>
                                      {{ showAmount($totalCharges) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-success text-white p-2 rounded">
                                    <strong>@lang('Total Deposits')</strong><br>
                                     {{ showAmount($totalDeposits) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="bg-danger text-white p-2 rounded">
                                    <strong>@lang('Pending Amount')</strong><br>
                                     {{ showAmount($pendingAmount) }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- School Charges -->
                            <div class="col-md-6">
                                <h5 class="text-primary">@lang('School Charges')</h5>
                                <table class="table table-striped table-bordered table-condensed mb-4">
                                    <thead>
                                        <tr>
                                            <th>@lang('Label')</th>
                                            <th>@lang('Amount')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($enrollment->feeHistories->where('action', '+') as $fee)
                                            <tr>
                                                <td>{{ $fee->label }}</td>
                                                <td>{{ showAmount($fee->amount) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-muted">@lang('No school charges found.')</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Deposit History -->
                            <div class="col-md-6">
                                <h5 class="text-success">@lang('Deposit History')</h5>
                                <table class="table table-striped table-bordered table-condensed mb-4">
                                    <thead>
                                        <tr>
                                            <th>@lang('Label')</th>
                                            <th>@lang('Amount')</th>
                                            <th>@lang('Payment Date')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($enrollment->feeHistories->where('action', '-') as $fee)
                                            <tr>
                                                <td>{{ $fee->label }}</td>
                                                <td>{{ showAmount($fee->amount) }}</td>
                                                <td>{{ showDateTime($fee->payment_date) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">@lang('No deposits found.')</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            
            <div class="col-md-12">
                <div class="card collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-users"></i> @lang('Parent Information')</h3>
            
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Expand">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <table class="table table-striped table-bordered table-condensed mb-none">
                            <tbody>
                                <tr>
                                    <th>@lang('Father Name')</th>
                                    <td>{{ $enrollment->student->guardianDetail->father_name }}</td>
                                    <th>@lang('Relation')</th>
                                    <td>{{ $enrollment->student->guardianDetail->grd_relation }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Mother Name')</th>
                                    <td>{{ $enrollment->student->guardianDetail->mother_name }}</td>
                                    <th>@lang('Occupation')</th>
                                    <td>{{ $enrollment->student->guardianDetail->grd_occupation }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Income')</th>
                                    <td>{{ number_format($enrollment->student->guardianDetail->grd_income, 2) }}</td>
                                    <th>@lang('Education')</th>
                                    <td>{{ $enrollment->student->guardianDetail->grd_education }}</td>
                                </tr>
                                <tr>
                                    <th>@lang('City')</th>
                                    <td>{{ $enrollment->student->guardianDetail->grd_city }}</td>
                                    <th>@lang('State')</th>
                                    <td>{{ $enrollment->student->guardianDetail->grd_state }} </td>
                                </tr>
                                <tr>
                                    <th>@lang('Mobile No')</th>
                                    <td>{{ $enrollment->student->guardianDetail->guardian_mobile }}</td>
                                    <th>@lang('Email')</th>
                                    <td >{{ $enrollment->student->guardianDetail->grd_email }}</td>
                                </tr>
                                <tr class="quick-address">
                                    <th>@lang('Address')</th>
                                    <td colspan="3" height="80px;">{{ $enrollment->student->guardianDetail->grd_address }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $('.card [data-card-widget="collapse"]').on('click', function () {
                var $currentCard = $(this).closest('.card');

                if ($currentCard.hasClass('collapsed-card')) {
                    $('.card').not($currentCard).not('.always-open').each(function () {
                        if (!$(this).hasClass('collapsed-card')) {
                            $(this).CardWidget('collapse');
                        }
                    });

                    $currentCard.CardWidget('expand');
                } else {
                    $currentCard.CardWidget('collapse');
                }
            });
        });
    </script>
@endsection