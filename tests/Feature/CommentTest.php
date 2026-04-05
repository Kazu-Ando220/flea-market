<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    private function createItem(User $seller): Item
    {
        return Item::factory()->create([
            'user_id'      => $seller->id,
            'category_id'  => Category::factory()->create()->id,
            'condition_id' => Condition::factory()->create()->id,
        ]);
    }

    /** @test */
    public function ログイン済みユーザーはコメントを送信できる()
    {
        $user   = User::factory()->create();
        $seller = User::factory()->create();
        $item   = $this->createItem($seller);

        $response = $this->actingAs($user)->post(route('comment.store', $item->id), [
            'content' => 'テストコメントです。',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメントです。',
        ]);
        $this->assertEquals(1, $item->comments()->count());
    }

    /** @test */
    public function 未認証ユーザーはコメントを送信できない()
    {
        $seller = User::factory()->create();
        $item   = $this->createItem($seller);

        $response = $this->post(route('comment.store', $item->id), [
            'content' => 'テストコメントです。',
        ]);

        $response->assertRedirect('/login');
        $this->assertEquals(0, $item->comments()->count());
    }

    /** @test */
    public function コメントが未入力の場合バリデーションメッセージが表示される()
    {
        $user   = User::factory()->create();
        $seller = User::factory()->create();
        $item   = $this->createItem($seller);

        $response = $this->actingAs($user)->post(route('comment.store', $item->id), [
            'content' => '',
        ]);

        $response->assertSessionHasErrors('content');
    }

    /** @test */
    public function コメントが255文字を超える場合バリデーションメッセージが表示される()
    {
        $user   = User::factory()->create();
        $seller = User::factory()->create();
        $item   = $this->createItem($seller);

        $response = $this->actingAs($user)->post(route('comment.store', $item->id), [
            'content' => str_repeat('あ', 256),
        ]);

        $response->assertSessionHasErrors('content');
    }
}