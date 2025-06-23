@extends('admin.layouts.app')

@section('panel')
<div class="container">
  <form action="{{ isset($class) ? route('admin.classes.update', $class->id) : route('admin.classes.store') }}" method="POST">
    @csrf
    @if(isset($class))
      @method('PUT')
    @endif

    <div class="card">
      <div class="card-header">
        <h3>{{ isset($class) ? 'Edit' : 'Create' }} Class</h3>
      </div>

      <div class="card-body">
        <div class="row">
          <div class="col-md-6 form-group">
            <label>Class Name<span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $class->name ?? '') }}" required>
          </div>
          <div class="col-md-6 form-group">
            <label>Fee<span class="text-danger">*</span></label>
            <input type="number" name="fee" class="form-control" value="{{ old('fee', $class->fee ?? '') }}" required>
          </div>

          <div class="col-md-6 form-group">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ old('description', $class->description ?? '') }}</textarea>
          </div>
        </div>

        <hr>
        <h5>Add Sections</h5>

        <div id="section-wrapper">
          @if(isset($class) && $class->sections)
            @foreach($class->sections as $key => $section)
              <div class="row section-item mb-2">
                <div class="col-md-5">
                  <input type="text" name="sections[{{ $key }}][name]" class="form-control" placeholder="Section Name" value="{{ $section->name }}">
                </div>
                <div class="col-md-5">
                  <input type="text" name="sections[{{ $key }}][description]" class="form-control" placeholder="Section Description" value="{{ $section->description }}">
                </div>
                <div class="col-md-2">
                  <button type="button" class="btn btn-danger remove-section">Remove</button>
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
                <button type="button" class="btn btn-danger remove-section">Remove</button>
              </div>
            </div>
          @endif
        </div>

        <button type="button" id="add-section" class="btn btn-info mb-3">Add More Section</button>
      </div>

      <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary">{{ isset($class) ? 'Update' : 'Create' }}</button>
      </div>
    </div>
  </form>
</div>

<script>
  let sectionIndex = {{ isset($class) && $class->sections ? count($class->sections) : 1 }};

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
          <button type="button" class="btn btn-danger remove-section">Remove</button>
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
