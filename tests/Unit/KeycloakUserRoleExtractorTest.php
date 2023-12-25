<?php

namespace Tests\Unit;

use App\KeycloakUserRoleExtractor;
use PHPUnit\Framework\TestCase;
use SocialiteProviders\Manager\OAuth2\User;

class KeycloakUserRoleExtractorTest extends TestCase
{
    public function test_extract_roles(): void
    {
        $user = new User();
        $user->user = [
            'resource_access' => [
                'cymais' => [
                    'roles' => ['%role-1%', '%role-2%']
                ]
            ]
        ];

        $extractor = new KeycloakUserRoleExtractor();
        $this->assertSame(['%role-1%', '%role-2%'], $extractor->extractRoles($user));
    }
}
