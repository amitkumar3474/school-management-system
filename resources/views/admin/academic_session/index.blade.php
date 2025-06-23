@extends('admin.layouts.app')
@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            {{-- === Session Form (Create or Edit) === --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-edit"></i> 
                            @isset($editsessions)
                                @lang('Edit Session')
                            @else
                                @lang('Add Session')
                            @endisset
                        </h3>
                    </div>
                    <form method="POST" action="{{ isset($editsessions) ? route('admin.academic-sessions.update', $editsessions->id) : route('admin.academic-sessions.store') }}">
                        @csrf
                        @isset($editsessions)
                            @method('PUT')
                        @endisset

                        <div class="card-body">
                            <div class="mb-3">
                                <label for="session">@lang('Session') <span class="text-danger">*</span></label>
                                <input type="text" name="session" id="session"
                                    class="form-control @error('session') is-invalid @enderror"
                                    value="{{ old('session', $editsessions->session ?? '') }}" required>
                                @error('session')<div class="text-danger">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                @isset($editsessions) @lang('Update') @else @lang('Save') @endisset
                            </button>
                            @isset($editsessions)
                                <a href="{{ route('admin.academic-sessions.index') }}" class="btn btn-secondary">@lang('Cancel')</a>
                            @endisset
                        </div>
                    </form>
                </div>
            </div>

            {{-- === Session List === --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title mb-0"><i class="fab fa-buromobelexperte"></i> @lang('All Session')</h3>
                            <form method="GET" action="{{ route('admin.academic-sessions.index') }}" class="d-inline-block w-100" style="max-width: 320px;">
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
                                    <th>@lang('Session')</th>
                                    <th>@lang('Status')</th>
                                    <th width="91">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sessions as $session)
                                    <tr>
                                        <td>{{ $session->session }}</td>
                                        <td>
                                            @if ($session->id == $general->academic_session_id??'')
                                                <span class="badge bg-success">@lang('Active')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.academic-sessions.index', ['edit' => $session->id]) }}" class="btn btn-warning btn-sm rounded-circle"><i class="fas fa-pen-nib"></i></a>
                                            @if (!$session->status == 1)
                                                <form action="{{ route('admin.academic-sessions.destroy', $session->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this academic sessions?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm rounded-circle">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $sessions->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
@section('scripts')
 
@endsection
