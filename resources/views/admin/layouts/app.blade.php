@extends('admin.layouts.master')
@section('content')
    <!-- page-wrapper start -->
    <div class="wrapper">
        @include('admin.partials.sidenav')
        @include('admin.partials.topnav')

        <div class="content-wrapper">
            @include('admin.partials.breadcrumb')
            @yield('panel')
        </div>
        @include('admin.partials.footer')
    </div>
@endsection
