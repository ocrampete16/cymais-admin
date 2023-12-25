@php use App\Enums\Permission; @endphp
<x-layout>
    <div class="section">
        <div class="container">
            <ul>
                @auth
                    <li>
                        <a href="{{ route('logout') }}">Log out</a>
                    </li>
                    @if(Auth::user()->hasPermissionTo(Permission::ADD_USER))
                        <li>
                            <a href="/">Add new user</a>
                        </li>
                    @endif
                @else
                    <li>
                        <a href="{{ route('login') }}">Log in</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</x-layout>
