@extends('admin.layouts.app')
@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="row">

            {{-- === Class Form (Create or Edit) === --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                      <h3  class="card-title">{{ isset($class) ? __('Edit Class & Sections') : __('Create Class & Section') }}</h3>
                    </div>
                    <form method="POST" action="{{ isset($class) ? route('admin.classes.update', $class->id) : route('admin.classes.store') }}">
                    @csrf
                    @if(isset($class))
                      @method('PUT')
                      @php
                        $sectionIndex = isset($class) && $class->sections ? count($class->sections) : 1;
                      @endphp 
                    @endif

                        <div class="card-body">
                            {{-- Name --}}
                            <div class="mb-3">
                                <label>@lang('Class Name')<span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $class->name ?? '') }}" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Fee --}}
                            <div class="mb-3">
                                <label>@lang('Fee')<span class="text-danger">*</span></label>
                                <input type="number" name="fee" class="form-control" value="{{ old('fee', $class->fee ?? '') }}" required>
                                @error('fee')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Description --}}
                            <div class="mb-3">
                                <label>@lang('Description')</label>
                                <textarea name="description" class="form-control">{{ old('description', $class->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr>
                          <h5>@lang('Add Sections')</h5>

                          <div id="section-wrapper">
                            @if(isset($class) && $class->sections)
                              @foreach($class->sections as $key => $section)
                              <div class="row section-item mb-2">
                                  <input type="hidden" name="sections[{{ $key }}][id]" value="{{ $section->id }}">
                                  <div class="col-md-5">
                                  <input type="text" name="sections[{{ $key }}][name]" class="form-control" placeholder="Section Name" value="{{ $section->name }}">
                                  </div>
                                  <div class="col-md-5">
                                  <input type="text" name="sections[{{ $key }}][description]" class="form-control" placeholder="Section Description" value="{{ $section->description }}">
                                  </div>
                                  <div class="col-md-2">
                                  <button type="button" class="btn btn-danger remove-section"><i class="fas fa-times"></i></button>
                                  </div>
                              </div>
                              @endforeach
                            @else
                              <div class="row section-item mb-2">
                              <div class="col-md-5">
                                  <input type="text" name="sections[0][name]" class="form-control" placeholder="Section Name">
                              </div>
                              <div class="col-md-5">
                                  <input type="text" name="sections[0][description]" class="form-control" placeholder="Section Description">
                              </div>
                              <div class="col-md-2">
                                  <button type="button" class="btn btn-danger remove-section"><i class="fas fa-times"></i></button>
                              </div>
                              </div>
                            @endif
                          </div>
                          <button type="button" id="add-section" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i></button>
                        </div>
                        
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                            {{ isset($class) ? 'Update' : 'Create' }}
                            </button>
                            @isset($class)
                                <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Cancel</a>
                            @endisset
                        </div>
                    </form>
                </div>
            </div>

            {{-- === Class List === --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Class & Section List</h3>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>@lang('Name')</th>
                                    <th>@lang('Fee')</th>
                                    <th>@lang('Description')</th>
                                    <th>@lang('Saction')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classes as $class)
                                    <tr>
                                        <td>{{ $class->name }}</td>
                                        <td>{{ showAmount($class->fee) }}</td>
                                        
                                        <td style="max-height: 500px;">
                                          <div style="max-height: 200px; max-width: 200px; overflow: auto; white-space: nowrap;">
                                                {{ $class->description }}
                                            </div>
                                        </td>
                                        <td>
                                        @if(!($class->sections->isEmpty()))
                                            @foreach($class->sections as $section)
                                              <span class="badge bg-warning">{{ $section->name }}</span>
                                            @endforeach
                                        @else
                                          <span class="text-muted">No sections</span>
                                        @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.classes.edit',$class->id) }}"
                                               class="btn btn-warning btn-sm rounded-circle"><i class="fas fa-pen"></i></a>
                                            <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST"
                                                  style="display:inline;" onsubmit="return confirm('Delete this Class?')">
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

<script>
  let sectionIndex = {{ $sectionIndex??1 }};
  console.log(sectionIndex);
  
  document.getElementById('add-section').addEventListener('click', function () {
    let wrapper = document.getElementById('section-wrapper');
    let html = `
      <div class="row section-item mb-2">
        <div class="col-md-5">
          <input type="text" name="sections[${sectionIndex}][name]" class="form-control" placeholder="Section Name">
        </div>
        <div class="col-md-5">
          <input type="text" name="sections[${sectionIndex}][description]" class="form-control" placeholder="Section Description">
        </div>
        <div class="col-md-2">
          <button type="button" class="btn btn-danger remove-section"><i class="fas fa-times"></i></button>
        </div>
      </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
    sectionIndex++;
  });

  document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('remove-section')) {
      e.target.closest('.section-item').remove();
    }
  });
</script>
@endsection