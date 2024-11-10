<?php
namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;

class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        \Illuminate\Support\Facades\Session::start();
        \Illuminate\Support\Facades\Session::put('_token', 'dummy');
    }

    #[Test]
    public function it_creates_a_user_with_custom_fields_except_username()
    {
        $user = User::factory()->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone_number' => '1234567890',
            'profile_bio' => 'This is a test bio.',
            'profile_picture' => '/test_picture.jpg',
            'is_administrator' => true,
        ]);

        $this->assertDatabaseHas('users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'phone_number' => '1234567890',
            'profile_bio' => 'This is a test bio.',
            'profile_picture' => '/test_picture.jpg',
            'is_administrator' => true,
        ]);
    }

    #[Test]
    public function it_can_update_user_with_username()
    {
        $user = User::factory()->create();

        $user->update(['username' => 'testuser123']);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => 'testuser123',
        ]);
    }

    #[Test]
    public function it_fails_to_create_a_user_with_invalid_data()
    {        $this->withoutMiddleware();

        $response = $this->postJson('/register', [
            'first_name' => '', // Vereist veld, leeg om validatie te forceren
            'last_name' => 'Doe',
            'email' => 'not-an-email', // Ongeldig e-mailadres
            'password' => 'short', // Te kort wachtwoord
            'password_confirmation' => 'short'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'first_name', 
            'email', 
            'password'
        ]);
    }

    #[Test]
    public function it_creates_a_user_on_valid_registration()
    {
        $response = $this->postJson('/register', [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'valid@example.com',
            'phone_number' => '0612345678',
            'password' => 'securepassword123!',
            'password_confirmation' => 'securepassword123!',
        ], ['X-CSRF-TOKEN' => csrf_token()]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'valid@example.com',
        ]);
    }

    #[Test]
    public function it_updates_user_profile()
    {
        $user = User::factory()->create();
    
        $response = $this->actingAs($user)->postJson(route('mijn-account.update-profile-user'), [
            'user_id' => $user->id,
            'username' => 'newusername',
            'profile_bio' => 'This is an updated bio.',
        ], ['X-CSRF-TOKEN' => csrf_token()]);
        
        $this->assertAuthenticatedAs($user);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'username' => 'newusername',
            'profile_bio' => 'This is an updated bio.',
        ]);
    }

    #[Test]
    public function it_fails_to_update_profile_with_duplicate_username()
    {
        $user1 = User::factory()->create();
        $user1->username = 'existinguser';
        $user1->save();

        $user2 = User::factory()->create();
        $user2->username = 'user2';
        $user2->save();
        
        // Probeer de gebruikersnaam van de tweede gebruiker bij te werken naar een bestaande gebruikersnaam
        $response = $this->actingAs($user2)->postJson(route('mijn-account.update-profile-user'), [
            'username' => 'existinguser',
            'profile_bio' => 'This is an updated bio.',
        ], ['X-CSRF-TOKEN' => csrf_token()]);
    
        $response->assertStatus(422);
        $this->assertEquals('user2', $user2->fresh()->username);
        $response->assertJsonValidationErrors(['username']);
    }
    
    #[Test]
    public function it_creates_an_admin_user()
    {
        $user = User::factory()->create([
            'first_name' => 'adminuser',
            'last_name' => 'Admin',
            'phone_number' => '123453490',
            'email' => 'admin@example.com',
            'password' => 'securepassword123',
            'profile_bio' => 'This is a test bio.',
            'profile_picture' => '/test_picture.jpg',
            'is_administrator' => true,
        ]);

        $this->assertDatabaseHas('users', [
            'first_name' => 'adminuser',
            'last_name' => 'Admin',
            'phone_number' => '123453490',
            'profile_bio' => 'This is a test bio.',
            'profile_picture' => '/test_picture.jpg',
            'is_administrator' => true,
        ]);
    }

    #[Test]
    public function it_creates_user_without_optional_fields()
    {
        $user = User::factory()->create([
            'first_name' => 'minimalUser',
            'last_name' => 'Minimal',
            'email' => 'minimaluser@example.com',
            'password' => 'securepassword123',
        ]);

        $this->assertDatabaseHas('users', [
            'first_name' => 'minimalUser',
            'last_name' => 'Minimal',
            'email' => 'minimaluser@example.com',
        ]);
    }

    #[Test]
    public function it_creates_an_address_for_user()
    {
        $user = User::factory()->create();
        $user->address()->create([
            'street' => 'Main Street',
            'house_number' => '123',
            'city' => 'ExampleCity',
            'postcode' => '12345',
            'country' => 'ExampleCountry',
        ]);

        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'street' => 'Main Street',
        ]);
    }

    #[Test]
    public function it_creates_visibility_settings_for_user()
    {
        $user = User::factory()->create();
        $user->visibilitySettings()->create([
            'show_email' => true,
            'show_phone' => false,
            'show_address' => true,
        ]);

        $this->assertDatabaseHas('user_visibility_settings', [
            'user_id' => $user->id,
            'show_email' => true,
            'show_address' => true,
        ]);
    }

    #[Test]
    public function it_creates_a_connection_between_two_users()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $user1->connections()->attach($user2->id);

        $this->assertDatabaseHas('user_connections', [
            'user_id' => $user1->id,
            'connected_user_id' => $user2->id,
        ]);
    }
}
