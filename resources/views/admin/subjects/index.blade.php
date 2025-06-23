@extends('admin.layouts.app')
@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            {{-- === Subject Form (Create or Edit) === --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                    <h3 class="card-title">{{ isset($class) ? __('Edit Subject') : __('Create Subject') }}</h3>
                    </div>
                    <form method="POST" action="{{ isset($subject) ? route('admin.subjects.update', $subject->id) : route('admin.subjects.store') }}">
                    @csrf
                    @if(isset($subject))
                      @method('PUT')
                    @endif

                        <div class="card-body">
                            {{-- Name --}}
                            <div class="mb-3">
                                <label>@lang('Subject Name')<span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $subject->name ?? '') }}" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- code --}}
                            <div class="mb-3">
                            <label for="code">@lang('Subject Code')<span class="text-danger">*</span></label>
                              <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', $subject->code ?? '') }}" required>
                              @error('code')
                                <span class="text-danger">{{ $message }}</span>
                              @enderror
                            </div>
                            <hr>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                            {{ isset($subject) ? 'Update' : 'Create' }}
                            </button>
                            @isset($subject)
                                <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Cancel</a>
                            @endisset
                        </div>
                    </form>
                </div>
            </div>

            {{-- === Subject List === --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('Subject List')</h3>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>@lang('Name')</th>
                                    <th>@lang('Code')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjects as $subject)
                                    <tr>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $subject->code }}</td>
                                        <td>
                                            <a href="{{ route('admin.subjects.edit',$subject->id) }}"
                                               class="btn btn-warning btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                                            <form action="{{ route('admin.subjects.destroy', $subject->id) }}" method="POST"
                                                  style="display:inline;" onsubmit="return confirm('Delete this Subject?')">
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
                        {{ $subjects->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection