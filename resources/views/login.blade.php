<x-layout>
    <div class="hero is-fullheight">
        <div class="hero-body">
            <div class="container">
                <div class="columns is-centered">
                    <div class="column is-3">
                        <div class="box">
                            <a class="button is-fullwidth is-primary" href="{{ route('openid_connect.redirect') }}">Login with Keycloak</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
