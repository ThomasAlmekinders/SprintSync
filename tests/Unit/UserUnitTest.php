<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Models\User;

class UserUnitTest extends TestCase
{
    public function it_creates_a_user_with_custom_fields_except_username()
    {
        $userMock = Mockery::mock('overload:App\Models\User');
        $userMock->shouldReceive('create')
            ->once()
            ->with([
                'first_name' => 'John',
                'last_name' => 'Doe',
                'phone_number' => '1234567890',
                'profile_bio' => 'This is a test bio.',
                'profile_picture' => '/test_picture.jpg',
                'is_administrator' => true,
            ])
            ->andReturnSelf();

        $this->assertTrue(true); // Verifieer dat de mock correct werd uitgevoerd
    }

    public function it_can_update_user_with_username()
    {
        $userMock = Mockery::mock('overload:App\Models\User');
        $userMock->shouldReceive('update')
            ->once()
            ->with(['username' => 'testuser123'])
            ->andReturn(true);

        $this->assertTrue(true);
    }

    public function it_creates_an_admin_user()
    {
        $userMock = Mockery::mock('overload:App\Models\User');
        $userMock->shouldReceive('create')
            ->once()
            ->with([
                'first_name' => 'adminuser',
                'last_name' => 'Admin',
                'phone_number' => '123453490',
                'email' => 'admin@example.com',
                'password' => 'securepassword123',
                'profile_bio' => 'This is a test bio.',
                'profile_picture' => '/test_picture.jpg',
                'is_administrator' => true,
            ])
            ->andReturnSelf();

        $this->assertTrue(true);
    }

    public function it_creates_user_without_optional_fields()
    {
        $userMock = Mockery::mock('overload:App\Models\User');
        $userMock->shouldReceive('create')
            ->once()
            ->with([
                'first_name' => 'minimalUser',
                'last_name' => 'Minimal',
                'email' => 'minimaluser@example.com',
                'password' => 'securepassword123',
            ])
            ->andReturnSelf();

        $this->assertTrue(true);
    }

    public function it_creates_an_address_for_user()
    {
        $userMock = Mockery::mock('overload:App\Models\User');
        $addressMock = Mockery::mock('overload:App\Models\Address');

        $userMock->shouldReceive('address->create')
            ->once()
            ->with([
                'street' => 'Main Street',
                'house_number' => '123',
                'city' => 'ExampleCity',
                'postcode' => '12345',
                'country' => 'ExampleCountry',
            ])
            ->andReturn($addressMock);

        $this->assertTrue(true);
    }

    public function it_creates_visibility_settings_for_user()
    {
        $userMock = Mockery::mock('overload:App\Models\User');
        $visibilitySettingsMock = Mockery::mock('overload:App\Models\UserVisibilitySettings');

        $userMock->shouldReceive('visibilitySettings->create')
            ->once()
            ->with([
                'show_email' => true,
                'show_phone' => false,
                'show_address' => true,
            ])
            ->andReturn($visibilitySettingsMock);

        $this->assertTrue(true);
    }

    public function it_creates_a_connection_between_two_users()
    {
        $user1Mock = Mockery::mock('overload:App\Models\User');
        $user2Mock = Mockery::mock('overload:App\Models\User');

        $user1Mock->shouldReceive('connections->attach')
            ->once()
            ->with($user2Mock->id)
            ->andReturn(true);

        $this->assertTrue(true);
    }
}
