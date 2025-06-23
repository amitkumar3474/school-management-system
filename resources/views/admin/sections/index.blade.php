@extends('admin.layouts.app')
@section('panel')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Section List</h3>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    
                                    <th>@lang('Class Name')</th>
                                    <th>@lang('Section')</th>
                                    <th>@lang('Description')</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($sections as $classId => $sectionGroup)
                                @php
                                    $className = $sectionGroup->first()->class->name ?? 'N/A';
                                @endphp
                                @foreach ($sectionGroup as $section)
                                    <tr>
                                        <td>{{ $className }}</td>
                                        <td>{{ $section->name }}</td>
                                        <td style="max-width: 200px; overflow-x: auto; white-space: nowrap;">
                                            {{ $section->description }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection