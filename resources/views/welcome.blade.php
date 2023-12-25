<x-layout>
    <div class="section">
        <div class="container">
            <ul>
                @auth
                    <li>
                        <a href="{{ route('logout') }}">Log out</a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}">Log in</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</x-layout>
