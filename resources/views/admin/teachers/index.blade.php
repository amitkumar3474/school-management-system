@extends('admin.layouts.app')
@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">@lang('Teachers')</h3>
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> @lang('New Teacher')
            </a>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0"><i class="fab fa-buromobelexperte"></i> @lang('All Teacher')</h3>
                            <form method="GET" action="{{ route('admin.teachers.index') }}" >
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('Search by name')" value="{{ request('search') }}">
                                    <button class="btn btn-sm btn-primary" type="submit">@lang('Search')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>

                                    <th>@lang('Photo')</th>
                                    <th>@lang('Staff ID')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Gender')</th>
                                    <th>@lang('Phone')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teachers as $teacher)
                                    <tr>
                                        <td>
                                            <img src="{{ $teacher->photo ? asset('storage/' . $teacher->photo) : asset('admin/images/user.png') }}" alt="teacher Photo" class="rounded-circle" width="50" height="50">
                                        </td>
                                        <td>{{ $teacher->staff_id }}</td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->gender }}</td>
                                        <td>{{ $teacher->phone }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>
                                            <span class="{{ $teacher->status ? 'badge bg-success' : 'badge bg-danger' }}">
                                                {{ $teacher->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.teachers.show', $teacher->id) }}" class="btn btn-sm btn-info rounded-circle" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-sm btn-warning rounded-circle"><i class="fas fa-pen-nib"></i></a>
                                            <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger rounded-circle" onclick="return confirm('Delete Teacher?')"><i class="fas fa-trash-alt"></i></button>
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
                        {{ $teachers->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection