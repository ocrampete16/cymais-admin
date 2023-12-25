@php use App\Enums\Permission; @endphp
<x-layout>
    <div class="section">
        <div class="container">
            <ul>
                @auth
                    <li>
                        <a href="{{ route('openid_connect.debug') }}">OpenID Connect Debug</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}">Log out</a>
                    </li>
                    @can(Permission::APPROVE_USER_REGISTRATION->value)
                        <li>
                            <a href="/">Approve user registration</a>
                        </li>
                    @endcan
                    @can(Permission::ADD_USER->value)
                        <li>
                            <a href="/">Add new user</a>
                        </li>
                    @endcan
                    @can(Permission::REMOVE_USER->value)
                        <li>
                            <a href="/">Remove user</a>
                        </li>
                    @endcan
                @else
                    <li>
                        <a href="{{ route('login') }}">Log in</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</x-layout>
