<?php
namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\ContactFormSubmission;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function contact_form_submission_stores_data_correctly()
    {
        $user = User::factory()->create(); // Om een ingelogde gebruiker te simuleren
        $this->get(route('contact.index')); // Om te beginnen met de route '/contact' inplaats van '/'

        $response = $this->actingAs($user)->post(route('contact.sendform'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'phone' => '1234567890',
            'subject' => 'Test Subject',
            'message' => 'Dit is een testbericht met voldoende lengte.',
        ]);

        $response->assertRedirect(route('contact.index'))
                 ->assertSessionHas('success', 'Uw bericht is succesvol verzonden.');

        $this->assertDatabaseHas('contact_form_submissions', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'subject' => 'Test Subject',
            'status' => 'new',
        ]);
    }

    #[Test]
    public function test_contact_form_submission_with_optional_fields_missing()
    {
        $this->get(route('contact.index')); // Om te beginnen met de route '/contact' inplaats van '/'

        $response = $this->post(route('contact.sendform'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'message' => 'Dit is een testbericht met voldoende lengte.',
        ]);

        $response->assertRedirect(route('contact.index'))
                ->assertSessionHas('success', 'Uw bericht is succesvol verzonden.');

        $this->assertDatabaseHas('contact_form_submissions', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'subject' => null,  // Optioneel veld
            'phone_number' => null,  // Optioneel veld
        ]);
    }

    #[Test]
    public function test_contact_form_requires_mandatory_fields()
    {
        $this->get(route('contact.index')); // Om te beginnen met de route '/contact' inplaats van '/'

        $response = $this->post(route('contact.sendform'), [
            'first_name' => '',
            'last_name' => '',
            'email' => 'invalid-email',
            'message' => '',
        ]);

        $response->assertSessionHasErrors(['first_name', 'last_name', 'email', 'message']);
    }

    #[Test]
    public function test_contact_form_max_length_validation()
    {
        $this->get(route('contact.index')); // Om te beginnen met de route '/contact' inplaats van '/'

        $response = $this->post(route('contact.sendform'), [
            'first_name' => str_repeat('A', 256),
            'last_name' => str_repeat('B', 256),
            'email' => 'johndoe@example.com',
            'message' => 'Dit is een testbericht met voldoende lengte.',
        ]);

        $response->assertSessionHasErrors(['first_name', 'last_name']);
    }

    #[Test]
    public function test_contact_form_rate_limiting()
    {
        $this->get(route('contact.index')); // Om te beginnen met de route '/contact' inplaats van '/'

        for ($i = 0; $i < 7; $i++) {
            $this->post(route('contact.sendform'), [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'johndoe@example.com',
                'message' => 'Dit is een testbericht met voldoende lengte.',
            ]);
        }

        $response = $this->post(route('contact.sendform'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'message' => 'Dit is een testbericht met voldoende lengte.',
        ]);

        $response->assertStatus(429); // 429 betekent "Too Many Requests"
    }

    #[Test]
    public function test_contact_form_handles_html_and_script_input_safely()
    {
        $this->get(route('contact.index')); // Om te beginnen met de route '/contact' inplaats van '/'

        $response = $this->post(route('contact.sendform'), [
            'first_name' => '<script>alert("XSS")</script>',
            'last_name' => '<b>Doe</b>',
            'email' => 'johndoe@example.com',
            'message' => 'Test bericht met <script>alert("XSS")</script>.',
        ]);

        $response->assertRedirect(route('contact.index'))
                ->assertSessionHas('success', 'Uw bericht is succesvol verzonden.');

        $this->assertDatabaseHas('contact_form_submissions', [
            'first_name' => '<script>alert("XSS")</script>',
            'last_name' => '<b>Doe</b>',
            'email' => 'johndoe@example.com',
        ]);
    }

    #[Test]
    public function test_contact_form_stores_additional_data()
    {  
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->get(route('contact.index')); // Om te beginnen met de route '/contact' inplaats van '/'

        $this->post(route('contact.sendform'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'message' => 'Dit is een testbericht met voldoende lengte.',
        ])->withHeaders(['X-Forwarded-For' => '127.0.0.1']);

        $this->assertDatabaseHas('contact_form_submissions', [
            'email' => 'johndoe@example.com',
            'logged_in_user_id' => $user->id,
        ]);

        $this->assertNotNull(ContactFormSubmission::where('email', 'johndoe@example.com')->first()->ip_address);
    }

}
