<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Message;

class MessagesControllerTest extends TestCase
{

    use RefreshDatabase;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        factory(\App\Task::class, 5)->create();
    }

    // public function setUp(): void
    // {
    //     parent::setUp();

    //     factory(Message::class, 20)->create();
    // }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexStatus()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testShowStatus()
    {
        $response = $this->get(route('messages.show', ['message' => 8]));

        $response->assertStatus(200);
        $response->assertSee('詳細ページ');
    }

    public function testCreateStatus()
    {
        $response = $this->get(route('messages.create', ['message' => 8]));

        $response->assertStatus(200);
        $response->assertSee('新規作成ページ');
    }

    public function testEditStatus()
    {
        $response = $this->get(route('messages.edit', ['message' => 8]));

        $response->assertStatus(200);
        $response->assertSee('編集ページ');
    }

    public function testStoreStatus()
    {
        $response = $this->post(route('messages.store', [
                'content' => 'テストメッセージ'
            ])
        );

        $response->assertRedirect('/');
        $response->assertStatus(302);
    }

    public function testUpdateStatus()
    {
        $response = $this->put(route('messages.update', [
                'message' => 8,
                'content' => 'testmessage'
            ])
        );

        $response->assertRedirect('/');
        $response->assertStatus(302);
    }

    public function testDeleteStatus()
    {
        $response = $this->delete(route('messages.destroy', [
                'message' => 8,
            ]
        ));
        $response->assertStatus(302);
    }
}
