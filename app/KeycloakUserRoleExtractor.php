<?php

namespace App;

use Illuminate\Support\Str;
use SocialiteProviders\Manager\OAuth2\User;

class KeycloakUserRoleExtractor
{
    /**
     * @return string[]
     */
    public function extractRoles(User $user): array
    {
        return collect($user->user)->dot()
            ->filter(fn($value, $key) => Str::startsWith($key, 'resource_access.cymais.roles.'))
            ->values()
            ->all();
    }
}
