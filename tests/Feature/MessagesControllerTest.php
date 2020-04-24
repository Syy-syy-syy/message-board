<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \Artisan;

use App\Message;

class MessagesControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        factory(Message::class, 5)->create();
    }

    public function tearDown(): void
    {
        Artisan::call('migrate:refresh');
        parent::tearDown();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexNomalCase()
    {
        // 実行
        $res = $this->get('/');

        // 検証
        $res->assertStatus(200);
    }

    public function testShowStatus()
    {
        // 実行
        $res = $this->get(route('messages.show', ['message' => 1]));

        // 検証
        $res->assertStatus(200);
        $res->assertSee('詳細ページ');
    }

    public function testCreateStatus()
    {
        // 実行
        $res = $this->get(route('messages.create', ['message' => 1]));

        // 検証
        $res->assertStatus(200);
        $res->assertSee('新規作成ページ');
    }

    public function testEditStatus()
    {
        // 実行
        $res = $this->get(route('messages.edit', ['message' => 1]));

        // 検証
        $res->assertStatus(200);
        $res->assertSee('編集ページ');
    }

    public function testStoreStatus()
    {
        // 実行
        $res = $this->post(route('messages.store', [
                'content' => 'テストメッセージ'
            ])
        );

        // 検証
        $res->assertRedirect('/');
        $res->assertStatus(302);
    }

    public function testStore_AfterDB()
    {
        // 実行
        $res = $this->post(route('messages.store', [
            'title' => 'テストタイトル',
            'content' => 'テストメッセージ'
        ])
    );

        // 検証
        $this->assertCount(6, Message::all());
        $this->assertDatabaseHas('messages', [
            'title' => 'テストタイトル',
            'content' => 'テストメッセージ'
        ]);
    }

    public function testUpdateStatus()
    {
        // 実行
        $res = $this->put(route('messages.update', [
                'message' => 1,
                'content' => 'testmessage'
            ])
        );

        // 検証
        $res->assertRedirect('/');
        $res->assertStatus(302);
    }

    public function testUpdateCheckDB()
    {
        // 実行
        $this->put(route('messages.update', [
                'message' => 1,
                'title' => 'testtitle',
                'content' => 'testmessage'
            ])
        );

        // 検証
        $this->assertDatabaseHas('messages', [
            'title' => 'testtitle',
            'content' => 'testmessage'
        ]);
        $this->assertEquals(5, Message::count());
    }

    public function testDeleteStatus()
    {
        // 実行
        $res = $this->delete(route('messages.destroy', [
                'message' => 1,
            ]
        ));

        // 検証
        $res->assertStatus(302);
    }

    public function testDeleteCheckDB()
    {
        // 準備
        $message = factory(Message::class)->create();

        // 実行
        $this->delete(route('messages.destroy', [
                'message' => 6,
            ]
        ));

        // 検証
        $this->assertCount(5, Message::all());
        $this->assertDeleted($message);
    }
}
