@extends('admin.layouts.app')

@section('panel')
  <section class="content">
    <form action="{{ route('admin.subjects.store') }}" method="POST">
      @csrf
      <div class="container-fluid">
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Create Subject</h3>
          </div>
          <div class="card-body">
            <div class="row">
              {{-- Subject Name --}}
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Subject Name</label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"  value="{{ old('name') }}">
                  @error('name')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
              </div>

              {{-- Subject Code --}}
              <div class="col-md-6">
                <div class="form-group">
                  <label for="code">Subject Code</label>
                  <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}">
                  @error('code')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Create</button>
          </div>
        </div>
      </div>
    </form>
  </section>
@endsection
