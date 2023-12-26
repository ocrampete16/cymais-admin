<?php

namespace Tests\Unit;

use App\KeycloakUser;
use PHPUnit\Framework\TestCase;
use SocialiteProviders\Manager\OAuth2\User;

class KeycloakUserTest extends TestCase
{
    /**
     * @dataProvider keycloak_users_with_unexpected_structure
     */
    public function test_throw_exception_if_keycloak_user_does_not_have_expected_structure(User $user): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new KeycloakUser($user);
    }

    public function test_return_empty_array_if_user_has_no_roles(): void
    {
        $user = new User();
        $user->user = [];

        self::assertSame([], (new KeycloakUser($user))->getRoles());
    }

    public function test_return_roles_if_user_has_roles(): void
    {
        $user = new User();
        $user->user = ['roles' => ['%role-1%', '%role-2%']];

        self::assertSame(['%role-1%', '%role-2%'], (new KeycloakUser($user))->getRoles());
    }

    public function keycloak_users_with_unexpected_structure(): \Generator
    {
        $user = new User();
        $user->user = [
            'roles' => '%not-an-array%'
        ];
        yield 'user with role property that is not an array' => [$user];

        $user = new User();
        $user->user = [
            'roles' => [1, 2, 3]
        ];
        yield 'user with role property that is not a string array' => [$user];
    }
}
