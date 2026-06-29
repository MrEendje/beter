<?php

namespace Tests\Feature;

use App\Models\Show;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowOverviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_displays_shows_when_they_exist()
    {
        // Given we have an active show
        $show = Show::create([
            'title' => 'Test Ballet Voorstelling',
            'description' => 'Dit is een mooie test omschrijving.',
            'date' => now()->addDays(5)->toDateTimeString(),
            'location' => 'Grote Zaal',
            'category' => 'Ballet',
            'available_tickets' => 100,
            'price' => 25.00,
            'is_active' => true,
        ]);

        // When we visit the home page
        $response = $this->get('/');

        // Then we see the show details
        $response->assertStatus(200);
        $response->assertSee('Test Ballet Voorstelling');
        $response->assertSee('Grote Zaal');
        $response->assertDontSee('Er zijn momenteel geen voorstellingen beschikbaar.');
    }

    public function test_it_displays_unhappy_scenario_message_when_no_shows_exist()
    {
        // Given there are no active shows in the database
        // When we visit the home page
        $response = $this->get('/');

        // Then we see the exact unhappy message
        $response->assertStatus(200);
        $response->assertSee('Er zijn momenteel geen voorstellingen beschikbaar.');
    }

    public function test_it_loads_the_about_page_successfully()
    {
        // When we visit the about page
        $response = $this->get('/over-ons');

        // Then it should return a successful response
        $response->assertStatus(200);
        $response->assertSee('Over Theater Aurora');
    }

    public function test_it_loads_the_contact_page_successfully()
    {
        // When we visit the contact page
        $response = $this->get('/contact');

        // Then it should return a successful response
        $response->assertStatus(200);
        $response->assertSee('Klantenservice');
        $response->assertSee('Contact');
        $response->assertSee('Veelgestelde Vragen');
    }

    public function test_unauthorized_users_cannot_access_employee_shows()
    {
        // Guest cannot access
        $this->get(route('employee.shows.index'))->assertRedirect(route('login'));

        // Visitor user cannot access
        $user = User::factory()->create(['role' => 'bezoeker']);
        $this->actingAs($user)
            ->get(route('employee.shows.index'))
            ->assertStatus(403);
    }

    public function test_authorized_employee_can_access_shows_management_and_crud()
    {
        $employee = User::factory()->create(['role' => 'medewerker']);
        
        $show = Show::create([
            'title' => 'Management Show',
            'description' => 'Test desc',
            'date' => now()->addDays(5)->toDateTimeString(),
            'location' => 'Foyer',
            'category' => 'Jazz',
            'available_tickets' => 50,
            'price' => 15.00,
            'is_active' => true,
        ]);

        // Access page
        $response = $this->actingAs($employee)->get(route('employee.shows.index'));
        $response->assertStatus(200);
        $response->assertSee('Management Show');
        $response->assertSee('Foyer');

        // Store new show
        $storeResponse = $this->actingAs($employee)->post(route('employee.shows.store'), [
            'title' => 'New Created Show',
            'description' => 'Brand new show',
            'date' => now()->addDays(10)->toDateTimeString(),
            'location' => 'Kleine Zaal',
            'category' => 'Theater',
            'available_tickets' => 120,
            'price' => 20.00,
            'is_active' => 1,
        ]);
        $storeResponse->assertRedirect(route('employee.shows.index'));
        $this->assertDatabaseHas('shows', ['title' => 'New Created Show']);

        // Update show
        $updateResponse = $this->actingAs($employee)->put(route('employee.shows.update', $show->id), [
            'title' => 'Updated Show Title',
            'description' => $show->description,
            'date' => $show->date->toDateTimeString(),
            'location' => $show->location,
            'category' => $show->category,
            'available_tickets' => $show->available_tickets,
            'price' => $show->price,
            'is_active' => 1,
        ]);
        $updateResponse->assertRedirect(route('employee.shows.index'));
        $this->assertDatabaseHas('shows', ['title' => 'Updated Show Title']);

        // Delete show
        $deleteResponse = $this->actingAs($employee)->delete(route('employee.shows.destroy', $show->id));
        $deleteResponse->assertRedirect(route('employee.shows.index'));
        $this->assertDatabaseMissing('shows', ['id' => $show->id]);
    }
}
