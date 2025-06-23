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
                                    <label for="session_id">@lang('Academic Session') <span class="text-danger">*</span></label>
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
                                    <label for="section_id">@lang('Section') <span class="text-danger">*</span></label>
                                    <select name="section_id" id="section_id" class="form-control" required>
                                        <option value="">-- @lang('Select Section') --</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="section_id">@lang('Student Name') <span class="text-danger" required>*</span></label>
                                    <select name="student_id" id="student_id" class="form-control">
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
            @if(!empty($enrollment) && $enrollment->total_fee != 0)
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-money-check-alt"></i> @lang('Fees')</h3>
                            <div class="card-tools">
                                <button type="button" 
                                    class="btn btn-sm btn-success open-fee-modal" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#feeModal"
                                    data-id="{{ $enrollment->id }}"
                                >
                                    <i class="fas fa-money-bill-wave"></i> @lang('Submit Fee')
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
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
            @endif
        </div>
    </div>
</section>

<!-- Fee Submission Modal -->
<div class="modal fade" id="feeModal" tabindex="-1" aria-labelledby="feeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.student.fee.store') }}" method="POST" class="frm-submit-data">
                @csrf
                <input type="hidden" name="enrollment_id" id="modalEnrollmentId">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="feeModalLabel"><i class="fas fa-money-check-alt"></i> @lang('Submit Student Fee')</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-tag text-primary"></i> @lang('Fee Label')<span class="text-danger">*</span></label>
                            <input type="text" name="label" class="form-control" placeholder="@lang('e.g., Tuition Fee')" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label"><i class="fas fa-dollar-sign text-primary"></i> @lang('Amount')<span class="text-danger">*</span></label>
                            <input type="number" name="amount" step="0.01" class="form-control" placeholder="@lang('Enter amount')" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="fas fa-calendar-alt text-primary"></i> @lang('Payment Date') <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="payment_date" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> @lang('Submit Fee')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {

        function loadStudents() {
            let classId = $('#class_id').val();
            let sessionId = $('#session_id').val();
            let sectionId = $('#section_id').val();
            var selectedStudentId = "{{ request('student_id') ?? '' }}";
            if (!classId) {
                $('#student_id').html('<option value="">-- Select student --</option>');
                return;
            }

            let url = "{{ route('admin.get.student.fee', [':sessionId', ':classId', ':sectionId']) }}"
                .replace(':sessionId', sessionId)
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
    });

    $(document).ready(function () {
        $('.open-fee-modal').on('click', function () {
            const id = $(this).data('id');
            $('#modalEnrollmentId').val(id);
        });
    });
</script>
@endsection