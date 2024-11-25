<?php
namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

use App\Models\User;
use App\Models\Scrumboard;

class ScrumboardTest extends TestCase
{
    #[Test]
    public function it_creates_a_new_scrumboard()
    {

        $user = User::factory()->create();
        $scrumboard = Scrumboard::factory()->create([
            'creator_id' => $user->id,
            'title' => 'New test scrumboard',
            'description' => 'Test beschrijving voor het nieuwe scurmboard',
            'active' => '1',
        ]);

        $this->assertDatabaseHas('scrumboards', [
            'creator_id' => $user->id,
            'title' => 'New test scrumboard',
            'description' => 'Test beschrijving voor het nieuwe scurmboard',
            'active' => '1',
        ]);
    }

    #[Test]
    public function test_controller_can_create_scrumbord()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('dashboard.index'));

        $response = $this->post(route('dashboard.create-scrumbord'), [
            'titel' => 'Test Scrumboard',
            'beschrijving' => 'Beschrijving van het scrumbord',
        ]);

        $this->assertDatabaseHas('scrumboards', [
            'title' => 'Test Scrumboard',
            'description' => 'Beschrijving van het scrumbord',
            'creator_id' => $user->id,
        ]);

        $response->assertRedirect(route('dashboard.index'));
        $response->assertSessionHas('success', 'Het scrumbord is aangemaakt!');
    }

    #[Test]
    public function it_requires_all_fields_to_create_a_scrumboard()
    {
        $user = User::factory()->create();

        $this->expectException(\Illuminate\Database\QueryException::class);

        Scrumboard::factory()->create([
            'creator_id' => $user->id,
            'title' => null,
        ]);
    }

    #[Test]
    public function it_belongs_to_a_creator()
    {
        $user = User::factory()->create();
        $scrumboard = Scrumboard::factory()->create(['creator_id' => $user->id]);

        $this->assertInstanceOf(User::class, $scrumboard->creator);
        $this->assertEquals($user->id, $scrumboard->creator->id);
    }

    #[Test]
    public function it_can_filter_active_scrumboards()
    {
        $activeScrumboard = Scrumboard::factory()->create(['active' => true]);
        $inactiveScrumboard = Scrumboard::factory()->create(['active' => false]);

        $activeScrumboards = Scrumboard::where('active', true)->get();

        $this->assertTrue($activeScrumboards->contains($activeScrumboard));
        $this->assertFalse($activeScrumboards->contains($inactiveScrumboard));
    }

    #[Test]
    public function it_deletes_a_scrumboard()
    {
        $scrumboard = Scrumboard::factory()->create();
    
        $scrumboard->delete();
    
        $this->assertDatabaseMissing('scrumboards', [
            'id' => $scrumboard->id,
        ]);
    }    

    #[Test]
    public function it_updates_an_existing_scrumboard()
    {
        $scrumboard = Scrumboard::factory()->create();

        $scrumboard->update([
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ]);

        $this->assertDatabaseHas('scrumboards', [
            'id' => $scrumboard->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ]);
    }

    #[Test]
    public function test_controller_can_update_scrumbord()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('dashboard.index'));
    
        $scrumboard = Scrumboard::factory()->create([
            'creator_id' => $user->id,
            'title' => 'Oud Scrumboard Titel',
            'description' => 'Oude beschrijving voor het scrumboard',
        ]);
    
        $response = $this->post(route('dashboard.update-scrumboard-settings'), [
            'scrumboard_id' => $scrumboard->id,
            'titel' => 'Nieuwe Scrumboard Titel',
            'beschrijving' => 'Nieuwe beschrijving voor het scrumboard',
            'actief' => true,
        ]);
    
        $this->assertDatabaseHas('scrumboards', [
            'id' => $scrumboard->id,
            'title' => 'Nieuwe Scrumboard Titel',
            'description' => 'Nieuwe beschrijving voor het scrumboard',
            'active' => true,
        ]);
    
        $response->assertRedirect(route('dashboard.index'));
        $response->assertSessionHas('success', 'De scrumbord instelling zijn bijgewerkt!');
    }    

    #[Test]
    public function it_creates_multiple_scrumboards()
    {
        $user = User::factory()->create();
        Scrumboard::factory()->count(10)->create(['creator_id' => $user->id]);

        $this->assertCount(10, Scrumboard::where('creator_id', $user->id)->get());
    }

}