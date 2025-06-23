@extends('admin.layouts.app')
@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            {{-- === User Form (Create or Edit) === --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-edit"></i> 
                            @isset($editUser)
                                @lang('Edit User')
                            @else
                                @lang('Add User')
                            @endisset
                        </h3>
                    </div>
                    <form method="POST" action="{{ isset($editUser) ? route('admin.users.update', $editUser->id) : route('admin.users.store') }}">
                        @csrf
                        @isset($editUser)
                            @method('PUT')
                        @endisset

                        <div class="card-body">
                            {{-- Name --}}
                            <div class="mb-3">
                                <label>@lang('Name') <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $editUser->name ?? '') }}" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label>@lang('Email') <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $editUser->email ?? '') }}" required>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="mb-3">
                                <label>@lang('Password') @unless(isset($editUser)) <span class="text-danger">*</span>  @else (@lang('Leave blank to keep same')) @endunless </label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-3">
                                <label>@lang('Confirm Password') @unless(isset($editUser)) <span class="text-danger">*</span>  @else (@lang('Leave blank to keep same')) @endunless</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>

                            {{-- Roles --}}
                            <div class="mb-3">
                                <label>@lang('Assign Roles') <span class="text-danger">*</span></label>
                                <div style="padding-bottom: 4px">
                                    <span class="btn btn-primary btn-xs select-all" style="border-radius: 0">@lang('Select all')</span>
                                    <span class="btn btn-primary btn-xs deselect-all" style="border-radius: 0">@lang('Deselect all')</span>
                                </div>
                                <select name="roles[]" class="form-control select2" multiple="multiple" data-placeholder="Select roles" id="roles-select">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}"
                                            @if(isset($editUser) && $editUser->hasRole($role->name)) selected @endif>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('roles')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                @isset($editUser) @lang('Update') @else @lang('Save') @endisset
                            </button>
                            @isset($editUser)
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                            @endisset
                        </div>
                    </form>
                </div>
            </div>

            {{-- === User List === --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row w-100 align-items-center">
                            <div class="col-md-6">
                                <h3 class="card-title mb-0"><i class="fab fa-buromobelexperte"></i> @lang('All User')</h3>
                            </div>
                            <div class="col-md-6 text-end">
                                <form method="GET" action="{{ route('admin.users.index') }}" class="d-inline-block w-100" style="max-width: 320px;">
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
                                    <th>@lang('Email')</th>
                                    <th>@lang('Roles')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->roles->isEmpty())
                                                <span class="text-muted">@lang('No Roles')</span>
                                            @else
                                                @foreach($user->roles as $role)
                                                    <span class="badge bg-info">{{ $role->name }}</span>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.users.index', ['edit' => $user->id]) }}"
                                               class="btn btn-warning btn-sm rounded-circle"><i class="fas fa-pen-nib"></i></a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                  style="display:inline;" onsubmit="return confirm('Delete this user?')">
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
                        {{ $users->links('pagination::bootstrap-5') }}
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
            let $select = $('#roles-select');
            $select.find('option').prop('selected', true);
            $select.trigger('change');
        });

        // Deselect All
        $('.deselect-all').click(function() {
            let $select = $('#roles-select');
            $select.find('option').prop('selected', false);
            $select.trigger('change');
        });
    </script>
@endsection
