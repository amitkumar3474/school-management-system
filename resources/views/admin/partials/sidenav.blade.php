<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ ($general->system_logo??'' !='') ? asset('storage/' . $general->system_logo) : asset('admin\images\logo.jpg') }}" alt="School Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">@lang('School Management')</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('admin/images/user.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ __(auth()->user()->name) }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>@lang('Dashboard')</p>
                    </a>
                </li>
                <li
                    class="nav-item has-treeview {{ request()->routeIs('admin.users*') || request()->routeIs('admin.permissions*') || request()->routeIs('admin.roles*') ? 'menu-open' : '' }}">
                    <a href="#"
                        class="nav-link {{ request()->routeIs('admin.users*') || request()->routeIs('admin.permissions*') || request()->routeIs('admin.roles*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            @lang('Manage Users')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}"
                                class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                                <i class="far fa-user nav-icon"></i>
                                <p>@lang('Users')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.index') }}"
                                class="nav-link {{ request()->routeIs('admin.permissions.index') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon"></i>
                                <p>@lang('Permissions')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}"
                                class="nav-link {{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon"></i>
                                <p>@lang('Roles')</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview {{ request()->routeIs('admin.students*') || request()->routeIs('admin.students.promote') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.students*') || request()->routeIs('admin.students.promote') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>
                            @lang('Manage Student')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.students.create') }}"
                                class="nav-link {{ request()->routeIs('admin.students.create') ? 'active' : '' }}">
                                <i class="far fa-edit"></i>
                                <p>@lang('Create Admission')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.students.index') }}"
                                class="nav-link {{ request()->routeIs('admin.students.index') ? 'active' : '' }}">
                                <i class="fas fa-users"></i>
                                <p>@lang('Students List')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.students.promote') }}"
                                class="nav-link {{ request()->routeIs('admin.students.promote') ? 'active' : '' }}">
                                <i class="fab fa-deviantart"></i>
                                <p>@lang('Promotion Student')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.students.tc') }}"
                                class="nav-link {{ request()->routeIs('admin.students.tc') ? 'active' : '' }}">
                                <i class="fas fa-file-alt"></i>
                                <p>@lang('Generate TC')</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{ request()->routeIs('admin.fee') || request()->routeIs('admin.fee') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.fee') || request()->routeIs('admin.fee') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice"></i>
                        <p>
                            @lang('Manage Fee')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.fee') }}"
                                class="nav-link {{ request()->routeIs('admin.fee') ? 'active' : '' }}">
                                <i class="far fa-edit"></i>
                                <p>@lang('Fee')</p>
                            </a>
                        </li>

                    </ul>
                </li>

                {{-- Manage Teacher Module --}}
                <li class="nav-item has-treeview {{ request()->routeIs('admin.teachers.*') || request()->routeIs('admin.teacher.class.subjects.list') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.teachers.*') || request()->routeIs('admin.teacher.class.subjects.list') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                    @lang('Manage Teacher')
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.teachers.index') }}" class="nav-link {{ request()->routeIs('admin.teachers.*') ? 'active' : '' }}">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <p>@lang('Teachers')</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.teacher.class.subjects.list') }}" class="nav-link {{ request()->routeIs('admin.teacher.class.subjects.list') ? 'active' : '' }}">
                        <i class="fas fa-tasks"></i>
                        <p>@lang('Assign class & subjects')</p>
                        </a>
                    </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{ request()->routeIs('admin.transports*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.transports*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-rss"></i>
                        <p>
                            @lang('Supervision')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.transports.index') }}"
                                class="nav-link {{ request()->routeIs('admin.transports.index') ? 'active' : '' }}">
                                <i class="fas fa-bus"></i>
                                <p>@lang('Transport')</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview {{ request()->routeIs('admin.attendance*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.attendance*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            @lang('Attendance')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.attendance.index') }}"
                                class="nav-link {{ request()->routeIs('admin.attendance.index') ? 'active' : '' }}">
                                <i class="fas fa-user"></i>
                                <p>@lang('Student')</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- Manage Masters Module --}}
                <li class="nav-item has-treeview {{ request()->routeIs('admin.classes.*') || request()->routeIs('admin.sections') || request()->routeIs('admin.subjects.*') || request()->routeIs('admin.class-subjects.*')  ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.classes.*') || request()->routeIs('admin.sections') || request()->routeIs('admin.subjects.*') || request()->routeIs('admin.class-subjects.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                    @lang('Manage Masters')
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.classes.index') }}" class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}">
                        <i class="fas fa-tasks"></i>
                        <p>@lang('Classes & Sections')</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.subjects.index') }}" class="nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">
                        <i class="fas fa-book-reader"></i>
                        <p>@lang('Subjects')</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.class-subjects.index') }}" class="nav-link {{ request()->routeIs('admin.class-subjects.*') ? 'active' : '' }}">
                        <i class="fas fa-dna"></i>
                        <p>@lang('Class & Subject')</p>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="{{ route('admin.students.promote') }}"
                            class="nav-link {{ request()->routeIs('admin.students.promote') ? 'active' : '' }}">
                            <i class="fab fa-deviantart"></i>
                            <p>@lang('Student Promotion')</p>
                        </a>
                    </li> -->
                    </ul>
                </li>

                {{-- Settings --}}
                <li class="nav-item has-treeview {{ request()->routeIs('admin.settings.index') || request()->routeIs('admin.academic-sessions*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('admin.settings.index') || request()->routeIs('admin.academic-sessions*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cogs"></i>
                    <p>
                    @lang('Settings')
                        <i class="fas fa-angle-left right"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.academic-sessions.index') }}"
                                class="nav-link {{ request()->routeIs('admin.academic-sessions.index') ? 'active' : '' }}">
                                <i class="fas fa-caret-right"></i>
                                <p>@lang('Session Settings')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                            <i class="fas fa-caret-right"></i>
                            <p>@lang('Global Settings')</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">
                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-sign-out-alt"></i> @lang('Logout')
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
