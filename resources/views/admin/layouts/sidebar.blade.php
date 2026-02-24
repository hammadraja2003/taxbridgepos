<ul id="side-main-menu" class="side-menu list-unstyled d-print-none">
    <li>
        <a href="{{ route('admin.admin_dashboard') }}">
            <i class="dripicons-meter"></i>
            <span>{{ __('dashboard') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.businesses.index') }}">
            <i class="dripicons-store"></i>
            <span>{{ __('businesses') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.packages.index') }}">
            <i class="dripicons-archive"></i>
            <span>{{ __('Packages') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.business_packages.index') }}">
            <i class="dripicons-briefcase"></i>
            <span>{{ __('Assign Packages') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.logs.index') }}">
            <i class="dripicons-clipboard"></i>
            <span>Logs</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.settings.mail') }}">
            <i class="dripicons-mail"></i>
            <span>Email Setting</span>
        </a>
    </li>
    <li>
        <a href="{{ route('admin.roles_permissions.index') }}" class="menu-item {{ request()->routeIs('admin.roles_permissions.*') ? 'active' : '' }}">
            <i class="dripicons-lock"></i>
            <span>Roles & Permissions</span>
        </a>
    </li>
    {{-- <li>
        <a href="{{ route('admin.support_tickets.index') }}">
            <i class="dripicons-ticket"></i>
            <span>Support Tickets</span>
        </a>
    </li> --}}
    <li id="logout-menu">
        <a href="{{ route('admin.logout_admin') }}"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="dripicons-power"></i>
            {{ __('logout') }}
        </a>
        <form id="logout-form" action="{{ route('admin.logout_admin') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</ul>
