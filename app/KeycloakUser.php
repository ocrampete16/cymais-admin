<?php

namespace App;

use SocialiteProviders\Manager\OAuth2\User;
use Webmozart\Assert\Assert;

class KeycloakUser
{
    public function __construct(private User $user)
    {
        if (array_key_exists('roles', $this->user->user)) {
            Assert::allString($this->user->user['roles']);
        }
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->user->user['roles'] ?? [];
    }
}
