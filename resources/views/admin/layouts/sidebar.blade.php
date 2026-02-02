<ul id="side-main-menu" class="side-menu list-unstyled d-print-none">
    <li><a href="{{route('admin.admin_dashboard')}}"> <i class="dripicons-meter"></i><span>{{__('dashboard')}}</span></a></li>
    <li><a href="{{ route('admin.businesses.index') }}"> <i class="dripicons-meter"></i><span>{{__('business')}}</span></a></li>
    <li><a href="{{ route('admin.packages.index') }}"> <i class="dripicons-meter"></i><span>{{__('Packages')}}</span></a></li>
    <li><a href="{{ route('admin.business_packages.index') }}"> <i class="dripicons-meter"></i><span>{{__('Assign Packages')}}</span></a></li>
    <li><a href="{{ route('admin.logs.index') }}"> <i class="dripicons-clipboard"></i><span>Logs</span></a></li>
    <li><a href="{{ route('admin.settings.mail') }}"> <i class="dripicons-gear"></i><span>Settings</span></a></li>
    {{-- <li><a href="{{ route('admin.support_tickets.index') }}"> <i class="dripicons-ticket"></i><span>Support Tickets</span></a></li> --}}
    <li id="logout-menu">
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                class="dripicons-power"></i>{{ __('logout') }}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </li>
</ul>