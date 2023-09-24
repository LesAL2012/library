<?php

namespace Tests\Feature\API;

use App\Models\Role;
use App\Models\User;
use App\Models\Writer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Inertia\Testing\AssertableInertia as Assert;

class WriterTest extends TestCase
{
    use RefreshDatabase;

    public function test_writer_can_be_stored(): void
    {
        $this->withoutExceptionHandling();
        $data = [
            'name' => 'Barbazotto',
        ];
        $response = $this->post('/api/swagger/writers', $data);
        $response->assertStatus(201);
        $this->assertDatabaseCount('writers', 1);
        $writer = Writer::first();
        $this->assertEquals($data['name'], $writer->name);
    }

    //'required|unique:writers|string|max:255',

    public function test_writer_invalid_attribute_name_not_store()
    {
        //$this->withoutExceptionHandling();
        $data = [
            'name' => '',
        ];
        $response = $this->post('/api/swagger/writers', $data);
        $response->assertRedirect();
        $response->assertInvalid('name');
    }

    public function test_writer_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $writer = Writer::factory()->create();
        $data = [
            'name' => 'Martozi',
        ];
        $response = $this->patch('/api/swagger/writers/' . $writer->id, $data);
        $response->assertOk();
        $writerUpdated = Writer::first();
        $this->assertEquals($data['name'], $writerUpdated->name);
        $this->assertEquals($writer->id, $writerUpdated->id);
    }

    public function test_writer_route_writers_index_view()
    {
        $this->withoutExceptionHandling();
        $items = 20;
        $writers = Writer::factory($items)->create();

        $response = $this->get('/api/test/writers');

        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Settings/Writers')
                ->has('title')
                ->where('title', 'All writers')
                ->has(
                    'writers',
                    fn (Assert $page) => $page
                        ->has('current_page')
                        ->has('data', 4)

                        ->has('data.0')
                        ->has('data.0.id')
                        ->has('data.0.name')
                        ->has('data.0.books_count')
                        ->where('data.0.books_count', 0)

                        ->has('first_page_url')
                        ->has('from')
                        ->has('last_page')
                        ->has('last_page_url')
                        ->has('links')
                        ->has('next_page_url')
                        ->has('path')
                        ->has('per_page')
                        ->has('prev_page_url')
                        ->has('to')

                        ->has('total')
                        ->where('total', $items)
                )
        );

        $names = $writers->pluck('name')->toArray();
        $response->assertSee($names[0]);
        $response->assertSee($names[1]);
        $response->assertSee($names[2]);
        $response->assertSee($names[3]);
    }

    public function test_writer_show()
    {
        $this->withoutExceptionHandling();
        $writer = Writer::factory()->create();
        $response = $this->get('/api/swagger/writers/' . $writer->id);
        $response->assertOk();
        $response->assertStatus(200);
        $dataResponse = $response->original->toArray();
        $this->assertDatabaseCount('writers', 1);
        $this->assertEquals($writer->id, 1);
        $this->assertEquals($writer->id, $dataResponse['id']);
        $this->assertEquals($writer->name, $dataResponse['name']);
    }

    public function test_writer_try_delete_role_admin()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        Role::create(['name'=>'admin']);
        $user->addRole('admin');
        $writer = Writer::factory()->create();
        $response = $this->actingAs($user)->delete('/api/test/writers/' . $writer->id);
        $response->assertOk();
        $response->assertStatus(200);
        $dataResponse = $response->original;
        $this->assertEquals($dataResponse['message'], "done");
        $this->assertEquals(null, Writer::find(1));
        $this->assertEquals(0, Writer::count());
    }

    public function test_writer_try_delete_role_not_admin()
    {
        //$this->withoutExceptionHandling();
        $user = User::factory()->create();
        Role::create(['name'=>'reader']);        $user->addRole('reader');
        $writer = Writer::factory()->create();
        $response = $this->actingAs($user)->delete('/api/test/writers/' . $writer->id);
        $response->assertStatus(403);
        $dataResponseMessage = $response->exception->getMessage();
        $this->assertEquals($dataResponseMessage, 'User does not have any of the necessary access rights.');
        $this->assertDatabaseCount('writers', 1);
        $this->assertEquals(1, Writer::count());
    }

    public function test_writer_try_delete_user_not_auth()
    {
        //$this->withoutExceptionHandling();
        $writer = Writer::factory()->create();
        $response = $this->delete('/api/test/writers/' . $writer->id);
        $response->assertStatus(302);
        $response->assertRedirect();
        $dataResponseMessage = $response->exception->getMessage();
        $this->assertEquals($dataResponseMessage, 'Unauthenticated.');
        $this->assertDatabaseCount('writers', 1);
        $this->assertEquals(1, Writer::count());
    }
}
