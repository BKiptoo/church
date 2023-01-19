<div>
    <ul class="nav nav-pills flex-column flex-md-row mb-3">
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}"
                                href="{{ route('profile') }}"><i
                    class="bx bx-user me-1"></i> Account</a></li>
        <li class="nav-item"><a class="nav-link {{ request()->routeIs('role.settings') ? 'active' : '' }}"
                                href="{{ route('role.settings') }}"><i
                    class="bx bx-shield-quarter me-1"></i> Role Settings</a></li>
        <li class="nav-item"><a
                class="nav-link {{ request()->routeIs('country.settings') ? 'active' : '' }}"
                href="{{ route('country.settings') }}"><i
                    class="bx bx-world me-1"></i> Countries Settings</a></li>
    </ul>
</div>
