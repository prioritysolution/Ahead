<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <a href="{{ route('Home') }}" class="logo logo-normal">
            <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo">
        </a>
        <a href="{{ route('Home') }}" class="logo-small">
            <img src="{{ asset('assets/img/logo-small.svg') }}" alt="Logo">
        </a>
        <a href="{{ route('Home') }}" class="dark-logo">
            <img src="{{ asset('assets/img/logo-white.svg') }}" alt="Logo">
        </a>
    </div>
    <!-- /Logo -->

    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul class="nav-menu">
                <li class="menu-title"><span>DASHBOARD</span></li>
                <li>
                    <ul>
                        <li>
                            <a href="{{ route('Home') }}" class="active">
                                <i class="ti ti-smart-home"></i>
                                <span>Dashboard</span>
                            </a>

                        </li>
                    </ul>
                </li>
                @foreach ($menue as $menues)
                    <li class="menu-title"><span>{{ $menues['module_name'] }}</span></li>
                    @foreach ($menues['parents'] as $parent)
                        <li>
                            <ul>
                                <li class="submenu">
                                    <a href="javascript:void(0);">
                                        <i class="ti ti-box"></i><span>{{ $parent['parent_name'] }}</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        @foreach ($parent['children'] as $child)
                                            @if (count($child['sub_children']) > 0)
                                                <li class="submenu submenu-two">
                                                    <a href="#">{{ $child['child_name'] }}<span
                                                            class="menu-arrow inside-submenu"></span></a>
                                                    <ul>
                                                        @foreach ($child['sub_children'] as $sub)
                                                            <li><a href="{{ isset($sub['route']) && Route::has($sub['route']) ? route($sub['route']) : '#' }}"> {{$sub['sub_name']}} </a>
                                                            </li>
                                                        @endforeach


                                                    </ul>
                                                </li>
                                            @else
                                                @if (!empty($child['child_name']))
                                                    <li>

                                                        <a href="{{ isset($child['route']) && Route::has($child['route']) ? route($child['route']) : '#' }}">{{ $child['child_name'] }}</a>
                                                    </li>
                                                @endif
                                            @endif
                                        @endforeach

                                    </ul>
                                </li>
                            </ul>
                        </li>
                    @endforeach
                @endforeach

                <li class="menu-title"><span>SETTINGS</span></li>
                <li>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="ti ti-settings"></i><span>Settings</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="#">General Settings</a></li>
                                <li><a href="#">Payroll Settings</a></li>
                                <li><a href="#">Salary Settings</a></li>
                                <li><a href="#">Financial Settings</a></li>
                                <li><a href="#">Roles Settings</a></li>
                                <li><a href="#">Activity Types</a></li>
                                <li><a href="#">Asset Categories</a></li>
                            </ul>
                        </li>

                        <!-- Bottom -->
                        <li><a href="#"><i class="ti ti-lock-square"></i><span>Lock Screen</span></a></li>
                        <li><a href="{{route('cng-pass')}}"><i class="ti ti-help-triangle"></i><span>Change Password</span></a></li>
                        <li><a href="{{ route('logout') }}"><i class="ti ti-logout"></i><span>Signout</span></a></li>

                    </ul>

                </li>




            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->
