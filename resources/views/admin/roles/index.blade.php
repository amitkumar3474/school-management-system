@extends('admin.layouts.app')

@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            {{-- Add / Edit Role Form --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <i class="far fa-edit"></i> {{ isset($editRole) ? __('Edit Role') : __('Add New Role') }}
                    </div>
                    <form method="POST" action="{{ isset($editRole) ? route('admin.roles.update', $editRole->id) : route('admin.roles.store') }}">
                        <div class="card-body">
                            @csrf
                            @if(isset($editRole)) @method('PUT') @endif
        
                            <div class="mb-3">
                                <label>@lang('Role Name') <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $editRole->name ?? '') }}" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
        
                            <div class="mb-3">
                                <label>@lang('Assign Permissions') <span class="text-danger">*</span></label>
                                <div style="padding-bottom: 4px">
                                    <span class="btn btn-primary btn-xs select-all" style="border-radius: 0">@lang('Select all')</span>
                                    <span class="btn btn-primary btn-xs deselect-all" style="border-radius: 0">@lang('Deselect all')</span>
                                </div>
                                <select name="permissions[]" id="permissions-select" class="form-control select2" multiple="multiple" data-placeholder="Select permissions" id="permissions-select">
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}"
                                            @if(isset($editRole) && $editRole->hasPermissionTo($permission->name)) selected @endif>
                                            {{ ucfirst($permission->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('permissions')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary">
                                {{ isset($editRole) ? __('Update') : __('Add') }}
                            </button>
                            @if(isset($editRole))
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            {{-- Role List --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row w-100 align-items-center">
                            <div class="col-md-6">
                                <h3 class="card-title mb-0"><i class="fab fa-buromobelexperte"></i> @lang('All Roles')</h3>
                            </div>
                            <div class="col-md-6 text-end">
                                <form method="GET" action="{{ route('admin.roles.index') }}" class="d-inline-block w-100" style="max-width: 320px;">
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
                                    <th>@lang('Permissions')</th>
                                    <th width="180">@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach ($role->permissions as $perm)
                                                <span class="badge bg-info">{{ $perm->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.roles.index', ['edit' => $role->id]) }}" class="btn btn-sm btn-warning rounded-circle"><i class="fas fa-pen-nib"></i></a>
                                            <form method="POST" action="{{ route('admin.roles.destroy', $role->id) }}" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger rounded-circle" onclick="return confirm('Delete this role?')"><i class="fas fa-trash-alt"></i></button>
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
                        {{ $roles->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
    <script>
        // select All
        $('.select-all').click(function() {
            let $select = $('#permissions-select');
            $select.find('option').prop('selected', true);
            $select.trigger('change');
        });

        // Deselect All
        $('.deselect-all').click(function() {
            let $select = $('#permissions-select');
            $select.find('option').prop('selected', false);
            $select.trigger('change');
        });
    </script>
@endsection