<?php

use App\KeycloakUser;
use App\KeycloakUserRoleExtractor;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::name('login')->get('/login', function () {
    return view('login');
});

Route::name('logout')->get('/logout', function () {
    Auth::user()->update([
        'access_token' => null,
        'refresh_token' => null,
    ]);
    Auth::logout();

    return redirect('/');
});

Route::prefix('openid-connect')->name('openid_connect.')->group(function () {
    Route::name('redirect')->get('/redirect', function () {
        return Socialite::driver('keycloak')->redirect();
    });

    Route::name('callback')->get('/callback', function () {
        /** @var \SocialiteProviders\Manager\OAuth2\User $keycloakUser */
        $keycloakUser = Socialite::driver('keycloak')->user();

        /** @var User $user */
        $user = User::updateOrCreate([
            'keycloak_id' => $keycloakUser->id,
        ], [
            'username' => $keycloakUser->nickname,
            'access_token' => $keycloakUser->token,
            'refresh_token' => $keycloakUser->refreshToken,
        ]);

        $roleNames = (new KeycloakUser($keycloakUser))->getRoles();

        $keycloakRoles = collect($roleNames)
            ->map(fn (string $roleName) => Role::where('name', $roleName)->first())
            ->filter();

        // Remove all roles that are assigned to the user locally but not on Keycloak
        foreach ($user->roles()->get() as $localRole) {
            if ($keycloakRoles->doesntContain(fn (Role $role, $key) => $role->is($localRole))) {
                $user->removeRole($localRole);
            }
        }

        // Add all roles that are assigned to the user on Keycloak but not locally
        foreach ($keycloakRoles as $keycloakRole) {
            if (!$user->hasRole($keycloakRole)) {
                $user->assignRole($keycloakRole);
            }
        }

        Auth::login($user);

        return redirect('/');
    });

    Route::name('debug')->get('/debug', function () {
        try {
            $user = Socialite::driver('keycloak')->userFromToken(Auth::user()->access_token);
        } catch (ClientException $exception) {
            if ($exception->getResponse()->getStatusCode() !== 401) {
                throw $exception;
            }

            $token = Socialite::driver('keycloak')->refreshToken(Auth::user()->refresh_token);
            Auth::user()->update([
                'access_token' => $token->token,
                'refresh_token' => $token->refreshToken,
            ]);

            $user = Socialite::driver('keycloak')->userFromToken($token->token);
        }

        dd($user);
    });
});
