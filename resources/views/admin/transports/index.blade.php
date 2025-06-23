@extends('admin.layouts.app')
@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            {{-- === Transport Form (Create or Edit) === --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-edit"></i> 
                            @isset($edittransport)
                                @lang('Edit Transport')
                            @else
                                @lang('Add Transport')
                            @endisset
                        </h3>
                    </div>
                    <form method="POST" action="{{ isset($edittransport) ? route('admin.transports.update', $edittransport->id) : route('admin.transports.store') }}">
                        @csrf
                        @isset($edittransport)
                            @method('PUT')
                        @endisset

                        <div class="card-body row">
                            <div class="col-md-6 mb-3">
                                <label for="route_name">@lang('Route Name') <span class="text-danger">*</span></label>
                                <input type="text" name="route_name" id="route_name"
                                    class="form-control @error('route_name') is-invalid @enderror"
                                    value="{{ old('route_name', $edittransport->route_name ?? '') }}" required>
                                @error('route_name')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="vehicle_no">@lang('Vehicle No') <span class="text-danger">*</span></label>
                                <input type="text" name="vehicle_no" id="vehicle_no"
                                    class="form-control @error('vehicle_no') is-invalid @enderror"
                                    value="{{ old('vehicle_no', $edittransport->vehicle_no ?? '') }}" required>
                                @error('vehicle_no')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="driver_name">@lang('Driver Name') <span class="text-danger">*</span></label>
                                <input type="text" name="driver_name" id="driver_name"
                                    class="form-control @error('driver_name') is-invalid @enderror"
                                    value="{{ old('driver_name', $edittransport->driver_name ?? '') }}" required>
                                @error('driver_name')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="driver_phone">@lang('Driver Phone') <span class="text-danger">*</span></label>
                                <input type="text" name="driver_phone" id="driver_phone"
                                    class="form-control @error('driver_phone') is-invalid @enderror"
                                    value="{{ old('driver_phone', $edittransport->driver_phone ?? '') }}" required>
                                @error('driver_phone')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="driver_license">@lang('Driver License') <span class="text-danger">*</span></label>
                                <input type="text" name="driver_license" id="driver_license"
                                    class="form-control @error('driver_license') is-invalid @enderror"
                                    value="{{ old('driver_license', $edittransport->driver_license ?? '') }}" required>
                                @error('driver_license')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="remarks">@lang('Remarks')</label>
                                <textarea name="remarks" id="remarks" rows="1"
                                    class="form-control @error('remarks') is-invalid @enderror">{{ old('remarks', $edittransport->remarks ?? '') }}</textarea>
                                @error('remarks')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="button" class="btn btn-success mb-3" id="add-sub-route">
                                    <i class="fas fa-plus-circle"></i>
                                </button>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="start_place">@lang('Start Place') <span class="text-danger">*</span></label>
                                <input type="text" name="start_place" id="start_place"
                                    class="form-control @error('start_place') is-invalid @enderror"
                                    value="{{ old('start_place', $edittransport->start_place ?? '') }}" required>
                                @error('start_place')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fee">@lang('Fee') <span class="text-danger">*</span></label>
                                <input type="text" name="fee" id="fee"
                                    class="form-control @error('fee') is-invalid @enderror"
                                    value="{{ old('fee', $edittransport->fee ?? '') }}" required>
                                @error('fee')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div id="sub-routes-wrapper" style="margin-left: 20px;">
                            @if(old('sub_start_place') && old('sub_fee'))
                                @foreach(old('sub_start_place') as $i => $startPlace)
                                    <div class="row sub-route-group mb-2">
                                        <div class="col-md-6 mb-3">
                                            <label>@lang('Start Place') <span class="text-danger">*</span></label>
                                            <input type="text" name="sub_start_place[]"
                                                class="form-control @error("sub_start_place.$i") is-invalid @enderror"
                                                value="{{ $startPlace }}" required>
                                            @error("sub_start_place.$i")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-5 mb-3">
                                            <label>@lang('Fee') <span class="text-danger">*</span></label>
                                            <input type="text" name="sub_fee[]"
                                                class="form-control @error("sub_fee.$i") is-invalid @enderror"
                                                value="{{ old('sub_fee')[$i] ?? '' }}" required>
                                            @error("sub_fee.$i")
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-1 mt-4">
                                            <button type="button" class="btn btn-danger remove-sub-route"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif($subroutes ?? false)
                                @foreach($subroutes as $sub)
                                    <div class="row sub-route-group mb-2">
                                        <input type="hidden" name="sub_id[]" value="{{ $sub->id }}">
                                        <div class="col-md-6 mb-3">
                                            <label>@lang('Start Place')</label>
                                            <input type="text" name="sub_start_place[]" class="form-control" value="{{ $sub->start_place }}" required>
                                        </div>
                                        <div class="col-md-5 mb-3">
                                            <label>@lang('Fee')</label>
                                            <input type="text" name="sub_fee[]" class="form-control" value="{{ $sub->fee }}" required>
                                        </div>
                                        <div class="col-md-1 mt-4">
                                            <button type="button" class="btn btn-danger remove-sub-route"><i class="fas fa-times"></i></button>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                @isset($edittransport) @lang('Update') @else @lang('Save') @endisset
                            </button>
                            @isset($edittransport)
                                <a href="{{ route('admin.transports.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                            @endisset
                        </div>
                    </form>
                </div>
            </div>

            {{-- === Transport List === --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0"><i class="fab fa-buromobelexperte"></i> @lang('All Transport')</h3>
                            <form method="GET" action="{{ route('admin.transports.index') }}" class="d-inline-block w-100" style="max-width: 320px;">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control"
                                           placeholder="@lang('Search by name')" value="{{ request('search') }}">
                                    <button class="btn btn-sm btn-primary" type="submit">@lang('Search')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>@lang('Route Name')</th>
                                    <th>@lang('Start Place')</th>
                                    <th>@lang('Vehicle No')</th>
                                    <th>@lang('Driver Name')</th>
                                    <th>@lang('Driver Phone')</th>
                                    <th width="140">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transports as $transport)
                                    <tr>
                                        <td>{{ $transport->route_name }}</td>
                                        <td>{{ $transport->start_place }}</td>
                                        <td>{{ $transport->vehicle_no }}</td>
                                        <td>{{ $transport->driver_name }}</td>
                                        <td>{{ $transport->driver_phone }}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-info btn-sm rounded-circle transport-view-btn" data-id="{{ $transport->id }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.transports.index', ['edit' => $transport->id]) }}"
                                               class="btn btn-warning btn-sm rounded-circle"><i class="fas fa-pen-nib"></i></a>
                                            <form action="{{ route('admin.transports.destroy', $transport->id) }}" method="POST"
                                                  style="display:inline;" onsubmit="return confirm('Delete this transports?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm rounded-circle">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $transports->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Transport View Modal -->
<div class="modal fade" id="quickView" tabindex="-1" aria-labelledby="transportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Transport Details')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="@lang('Close')"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered table-condensed mb-none">
                    <tbody>
                        <tr>
                            <th>@lang('Route Name')</th>
                            <td colspan="3"><span id="quick_route_name"></span></td>
                        </tr>
                        <tr>
                            <th>@lang('Stop Place')</th>
                            <td><span id="quick_stop_place"></span></td>
                            <th>@lang('Driver Name')</th>
                            <td><span id="quick_driver_name"></span></td>
                        </tr>
                        <tr>
                            <th>@lang('Driver Phone')</th>
                            <td><span id="quick_driver_phone"></span></td>
                            <th>@lang('License')</th>
                            <td><span id="quick_driver_license"></span></td>
                        </tr>
                        <tr>
                            <th>@lang('Vehicle No')</th>
                            <td><span id="quick_vehicle_no"></span></td>
                            <th>@lang('Remarks')</th>
                            <td ><span id="quick_remarks"></span></td>
                        </tr>
                        <tr>
                            <th> @lang('Sub Transport')</th>
                            <td colspan="3">
                                <table class="table table-striped table-bordered table-condensed mb-none">
                                    <thead>
                                        <tr>
                                            <th>@lang('Start Place')</th>
                                            <th>@lang('Fee')</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sub-routes-list">
                                        <tr>
                                            <td><span id="quick_start_place"></span></td>
                                            <td><span id="quick_fee"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).on('click', '.transport-view-btn', function () {
        const id = $(this).data('id');

        $.ajax({
            url: `/admin/transports/${id}`,
            type: 'GET',
            success: function (data) {
                $('#quick_route_name').text(data.route_name);
                $('#quick_start_place').text(data.start_place);
                $('#quick_stop_place').text(data.stop_place || 'RK');
                $('#quick_vehicle_no').text(data.vehicle_no);
                $('#quick_driver_name').text(data.driver_name);
                $('#quick_driver_phone').text(data.driver_phone);
                $('#quick_driver_license').text(data.driver_license);
                $('#quick_fee').text('₹' + data.fee);
                $('#quick_remarks').text(data.remarks || 'N/A');

                let subRouteHtml = '';
                data.sub_routes.forEach(route => {
                    subRouteHtml += `<tr><td>${route.start_place}</td><td>₹${route.fee}</td></tr>`;
                });
                $('#sub-routes-list').append(subRouteHtml || '<tr><td colspan="2">No Sub Routes</td></tr>');

                $('#quickView').modal('show');
            },
            error: function () {
                alert('Failed to load data.');
            }
        });
    });
    $(document).ready(function () {
        $('#add-sub-route').on('click', function () {
            let html = `
            <div class="row sub-route-group mb-2">
                <div class="col-md-6 mb-3">
                    <label>@lang('Start Place') <span class="text-danger">*</span></label>
                    <input type="text" name="sub_start_place[]" class="form-control" required>
                </div>
                <div class="col-md-5 mb-3">
                    <label>@lang('Fee') <span class="text-danger">*</span></label>
                    <input type="text" name="sub_fee[]" class="form-control" required>
                </div>
                <div class="col-md-1 mb-3 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-sub-route"><i class="fas fa-times"></i></button>
                </div>
            </div>`;
            
            $('#sub-routes-wrapper').append(html);
        });

        // Remove sub-route
        $(document).on('click', '.remove-sub-route', function () {
            $(this).closest('.sub-route-group').remove();
        });
    });
    </script>
@endsection
