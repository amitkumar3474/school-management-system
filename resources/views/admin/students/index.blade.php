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
                            <div>
                                <button type="button" class="btn btn-warning btn-sm me-2" id="other-charges-btn">
                                    <i class="fas fa-plus-circle"></i> @lang('Other Charges')
                                </button>
                                <button type="button" class="btn btn-success btn-sm" id="bulk-generate-fee">
                                    <i class="fas fa-money-bill-wave"></i> @lang('Generate Fee (Bulk)')
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="select-all"></input></th>
                                    <th>@lang('Photo')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Father')</th>
                                    <th>@lang('Class')</th>
                                    <th>@lang('Saction')</th>
                                    <th>@lang('Mobile')</th>
                                    <th width="180">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($students as $enrollment)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="select-student" name="enrollment_ids[]" value="{{ $enrollment->id }}"></input>
                                        </td>
                                        <td style="text-align: center;">
                                            <img src="{{ $enrollment->student->photo ? asset('storage/' . $enrollment->student->photo) : asset('admin/images/user.png') }}" alt="@lang('Student Photo')" class="" width="50" height="50">
                                        </td>
                                        <td>{{ $enrollment->student->student_name }}</td>
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
                                            @if ($enrollment->student->detail)
                                                <a href="{{ route('admin.students.show', $enrollment->id) }}" class="btn btn-info btn-sm rounded-circle" title="View" target="_blank">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.students.edit', $enrollment->id) }}" class="btn btn-sm btn-warning rounded-circle"><i class="fas fa-pen-nib"></i></a>
                                            @if ($enrollment->feeHistories->count() > 0)
                                                <button 
                                                    type="button" 
                                                    class="btn btn-sm btn-success rounded-circle open-fee-modal" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#feeModal"
                                                    data-id="{{ $enrollment->id }}"
                                                    data-name="{{ $enrollment->student->student_name }}"
                                                    data-class="{{ $enrollment->class->name }}"
                                                    data-total="{{ $enrollment->total_fee }}"
                                                    data-paid="{{ $enrollment->pending_fee }}"
                                                >
                                                <i class="fas fa-rupee-sign"></i>
                                            </button>
                                            @endif
                                            <form action="{{ route('admin.students.destroy', $enrollment->id) }}" method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger rounded-circle delete-student-btn"><i class="fas fa-trash-alt"></i></button>
                                            </form>
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

<!-- Other Charges Modal -->
<div class="modal fade" id="otherChargesModal" tabindex="-1" aria-labelledby="otherChargesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.student.other.charges.store') }}" method="POST" class="frm-submit-other-charges">
                @csrf
                <input type="hidden" name="enrollment_ids" id="otherChargesEnrollmentIds">

                <div class="modal-header bg-primary text-dark">
                    <h5 class="modal-title" id="otherChargesModalLabel"><i class="fas fa-plus-circle"></i> @lang('Add Other Charges')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">@lang('Charge Label') <span class="text-danger">*</span></label>
                        <input type="text" name="label" class="form-control" placeholder="@lang('e.g., Late Fee, Exam Fee')" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">@lang('Amount') <span class="text-danger">*</span></label>
                        <input type="number" name="amount" step="0.01" class="form-control" placeholder="@lang('Enter amount')" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> @lang('Submit Charges')</button>
                </div>
            </form>
        </div>
    </div>
</div>


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
                    <div class="mb-3">
                        <strong>@lang('Student'):</strong> <span id="studentName" class="text-info"></span> |
                        <strong>@lang('Class'):</strong> <span id="studentClass" class="text-info"></span> |
                        <strong>@lang('Total Fee'):</strong> ₹<span id="totalFee" class="text-success"></span> |
                        <strong>@lang('Pending'):</strong> ₹<span id="pendingFee" class="text-danger"></span>
                    </div>

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
    $(document).ready(function() {
        $('#class_id').on('change', function() {
            console.log("SDsdf");
            
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
        });
        $(document).ready(function() {
            const teacherId = $('#class_id').val();
            if (teacherId) {
                $('#class_id').trigger('change');
            }
        });

        $(document).ready(function () {
            // Master checkbox logic
            $('#select-all').on('change', function () {
                $('.select-student').prop('checked', $(this).is(':checked'));
                // toggleBulkButton();
            });

            // Individual checkbox logic
            $('.select-student').on('change', function () {
                if (!$(this).is(':checked')) {
                    $('#select-all').prop('checked', false);
                }
                // toggleBulkButton();
            });

            // Toggle Bulk Generate Fee button
            // function toggleBulkButton() {
            //     let selected = $('.select-student:checked').length;
            //     if (selected > 0) {
            //         $('#bulk-generate-fee').show();
            //     } else {
            //         $('#bulk-generate-fee').hide();
            //     }
            // }

            // Optional: Handle bulk generate fee click
            $('#bulk-generate-fee').on('click', function () {
                let ids = $('.select-student:checked').map(function () {
                    return $(this).val();
                }).get();

                if (ids.length > 0) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You are about to generate fees for selected students.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, generate!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let url = "{{ route('admin.student.fee.generate.bulk') }}?ids=" + ids.join(',');
                            window.location.href = url;
                        }
                    });
                }else{
                    Swal.fire({
                    icon: 'warning',
                    title: 'No Students Selected',
                    text: 'Please select at least one student to generate fees.',
                    confirmButtonColor: '#e0a800',
                    confirmButtonText: 'Got it'
                });
                }
            });

            $('#other-charges-btn').on('click', function () {
                let ids = $('.select-student:checked').map(function () {
                    return $(this).val();
                }).get();

                if (ids.length > 0) {
                    $('#otherChargesEnrollmentIds').val(ids.join(','));
                    $('#otherChargesModal').modal('show');
                }else{
                    Swal.fire({
                    icon: 'warning',
                    title: 'No Students Selected',
                    text: 'Please select at least one student to apply other charges.',
                    confirmButtonColor: '#e0a800',
                    confirmButtonText: 'Got it'
                });
                }
            });

            // student delete button
            $('.delete-student-btn').on('click', function (e) {
                e.preventDefault();
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action will permanently delete the student record.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        $(document).ready(function () {
            $('.open-fee-modal').on('click', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const studentClass = $(this).data('class');
                const total = parseFloat($(this).data('total')) || 0;
                const pending = parseFloat($(this).data('paid')) || 0;

                $('#modalEnrollmentId').val(id);
                $('#studentName').text(name);
                $('#studentClass').text(studentClass);
                $('#totalFee').text(total.toFixed(2));
                $('#pendingFee').text(pending.toFixed(2));
            });
        });
</script>
@endsection