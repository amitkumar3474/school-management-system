@extends('admin.layouts.app')
@section('styles')

@endsection
@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            {{-- Form: Add or Edit --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="far fa-edit"></i> {{ isset($editPermission) ? __('Edit Permission') : __('Add New Permissions') }}
                    </div>
                    <form method="POST" action="{{ isset($editPermission) ? route('admin.permissions.update', $editPermission->id) : route('admin.permissions.store') }}">
                        <div class="card-body">
                            @csrf
                            @if (isset($editPermission))
                                @method('PUT')
                                {{-- Single edit input --}}
                                <div class="mb-3">
                                    <label>@lang('Permission Name') <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $editPermission->name) }}" required>
                                    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                                </div>
                            @else
                                {{-- Multiple input mode --}}
                                <div class="mb-3">
                                    <label>@lang('Permission Names')<span class="text-danger">*</span></label>
                                    <div id="permission-list">
                                        <div class="input-group mb-2">
                                            <input type="text" name="names[]" class="form-control" placeholder="@lang('Permission name')" required>
                                        </div>
                                    </div>
                                    @error('names') <div class="text-danger">{{ $message }}</div> @enderror
                                    <button type="button" class="btn btn-success mb-3" id="add-permission">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            @endif

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($editPermission) ? __('Update') : __('Save All') }}
                            </button>
    
                            @if (isset($editPermission))
                                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table: Permissions List --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row w-100 align-items-center">
                            <div class="col-md-6">
                                <h3 class="card-title mb-0"><i class="fab fa-buromobelexperte"></i> @lang('All Permissions')</h3>
                            </div>
                            <div class="col-md-6 text-end">
                                <form method="GET" action="{{ route('admin.permissions.index') }}" class="d-inline-block w-100" style="max-width: 320px;">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="search" class="form-control"
                                               placeholder="@lang('Search by name')" value="{{ request('search') }}">
                                        <button class="btn btn-sm btn-primary" type="submit">@lang('Search')</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th width="180">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.permissions.index', ['edit' => $permission->id]) }}"
                                                class="btn btn-warning btn-sm rounded-circle" title="@lang('Edit')">
                                                <i class="fas fa-pen-nib"></i>
                                            </a>

                                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                                  method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button onclick="return confirm('Delete this permission?')"
                                                        class="btn btn-danger btn-sm rounded-circle" title="@lang('Delete')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">@lang('No permissions found.')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $permissions->links('pagination::bootstrap-5') }}
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
        $('#add-permission').click(function () {
            const inputGroup = `
                <div class="input-group mb-2">
                    <input type="text" name="names[]" class="form-control" placeholder="@lang('Permission name')" required>
                    <button type="button" class="btn btn-danger remove-permission"><i class="fas fa-times"></i></button>
                </div>`;
            $('#permission-list').append(inputGroup);
        });

        $(document).on('click', '.remove-permission', function () {
            $(this).closest('.input-group').remove();
        });
    });
</script>
@endsection
