@extends('admin.layouts.app')
@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="row">

            {{-- === Class & Subject (Create or Edit) === --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="far fa-edit"></i> {{ isset($editClass) ? __('Edit Class & Subject') : __('Create Class & Subject') }}
                        </div>
                    </div>
                    <form method="POST" action="{{ isset($editClass) ? route('admin.class-subjects.update', $editClass->id) : route('admin.class-subjects.store') }}">
                    @csrf
                    @if(isset($editClass))
                      @method('PUT')
                    @endif

                        <div class="card-body">
                            {{-- class_id --}}
                            <div class="mb-3">
                            <label>@lang('Class Name')<span class="text-danger">*</span></label>
                            <select class="form-control" name="class_id" required>
                                <option value="">-- @lang('Select Class') --</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $editClass->id ?? '') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                                @error('class_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- subject_id --}}
                            <div class="mb-3">
                                <label>@lang('Subject Name')<span class="text-danger">*</span></label>
                                @php
                                    $selSubj = (isset($editClass))?$editClass->subjects->pluck('id')->toArray():[];
                                @endphp
                                <select class="form-control select2" name="subject_id[]" multiple="multiple" required>
                                    <option value="">-- Select Subject --</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ in_array($subject->id, old('subject_id', $selSubj)) ? 'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('subject_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <hr>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                            <!-- {{ isset($editClass) ? 'Update' : 'Create' }} -->
                            {{ isset($editClass) ? __('Update Subjects') : __('Assign Subjects') }}
                            </button>
                            @isset($editClass)
                                <a href="{{ route('admin.class-subjects.index') }}" class="btn btn-secondary">Cancel</a>
                            @endisset
                        </div>
                    </form>
                </div>
            </div>

            {{-- === Class & Subject List === --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> <i class="fab fa-buromobelexperte"></i> @lang('Class & Subject List')</h3>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>@lang('Class Name')</th>
                                    <th>@lang('Subject Name')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classes as $_class)
                                    <tr>
                                        <td>{{ $_class->name }}</td>
                                        <td>
                                            @foreach($_class->subjects as $_subject)
                                                <span class="badge bg-secondary">{{ $_subject->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.class-subjects.edit',$_class->id) }}"
                                               class="btn btn-warning btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                                            <form action="{{ route('admin.class-subjects.destroy', $_class->id) }}" method="POST"
                                                  style="display:inline;" onsubmit="return confirm('Delete this Class & Subject?')">
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
                        {{ $classes->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    //Initialize Select2 Elements
    $('.select2').select2()
</script>
@endsection
