<?php

namespace Tests\Unit\Models;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function test_user_has_correct_fillables()
    {
        $user = new User();
        $expectedFillables = ['name', 'email', 'password'];

        $this->assertEquals($expectedFillables, $user->getFillable());
    }

    public function test_user_has_correct_hidden_attributes()
    {
        $user = new User();
        $expectedHidden = ['password', 'remember_token'];

        $this->assertEquals($expectedHidden, $user->getHidden());
    }

    public function test_user_casts_attributes_correctly()
    {
        $user = new User();
        $casts = $user->getCasts();

        $this->assertArrayHasKey('email_verified_at', $casts);
        $this->assertArrayHasKey('password', $casts);
        $this->assertEquals('datetime', $casts['email_verified_at']);
        $this->assertEquals('hashed', $casts['password']);
    }

    public function test_user_implements_jwt_subject_interface()
    {
        $user = new User();
        $this->assertInstanceOf(\PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject::class, $user);
    }

    public function test_get_jwt_identifier_returns_key()
    {
        $user = new User();
        $user->id = 1;
        $this->assertEquals(1, $user->getJWTIdentifier());
    }

    public function test_get_jwt_custom_claims_returns_empty_array()
    {
        $user = new User();
        $this->assertEquals([], $user->getJWTCustomClaims());
    }
}
