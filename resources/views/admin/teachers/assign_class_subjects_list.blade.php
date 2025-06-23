@extends('admin.layouts.app')
@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">@lang('Assign class & subjects')</h3>
            <a href="{{ route('admin.teacher.class.subjects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> @lang('New Assign class & subjects')
            </a>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0"><i class="fab fa-buromobelexperte"></i> @lang('All Teacher')</h3>
                            <form method="GET" action="{{ route('admin.teacher.class.subjects.list') }}" >
                                <div class="input-group input-group-sm">
                                    <input type="text" name="search" class="form-control" placeholder="@lang('Search')" value="{{ request('search') }}">
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
                                    <th>@lang('Teacher Name')</th>
                                    <th>@lang('Class')</th>
                                    <th>@lang('Section')</th>
                                    <th>@lang('Subjects')</th>
                                    <th>@lang('Action')</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assignments as $group)
                                    @php
                                        $first = $group['records']->first();
                                        $teacher = $first->teacher;
                                    @endphp
                                    <tr>
                                        <td>
                                            <img src="{{ $teacher->photo ? asset('storage/' . $teacher->photo) : asset('admin/images/user.png') }}"
                                                alt="teacher Photo" class="rounded-circle" width="50" height="50">
                                        </td>
                                        <td><a href="{{ route('admin.teachers.show', $teacher->id) }}">{{ $teacher->name }}</a></td>
                                        <td><span class="badge bg-info">{{ $first->class->name }}</span></td>
                                        <td><span class="badge bg-warning">{{ $first->section->name }}</span></td>
                                        <td>
                                            @foreach($group['records']->pluck('subject.name')->unique() as $subjectName)
                                                <span class="badge bg-secondary">{{ $subjectName }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.teacher.class.subjects.edit', $first->id) }}" class="btn btn-sm btn-warning rounded-circle">
                                                <i class="fas fa-pen-nib"></i>
                                            </a>
                                            <form action="{{ route('admin.teacher.class.subjects.delete', $first->id) }}" method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger rounded-circle" onclick="return confirm('Delete Teacher?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No teacher assignments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $pagination->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection