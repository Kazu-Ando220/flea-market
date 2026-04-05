<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Like;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LikeTest extends TestCase
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
    public function いいねアイコンを押下するといいねした商品として登録されいいね合計値が増加する()
    {
        $user   = User::factory()->create();
        $seller = User::factory()->create();
        $item   = $this->createItem($seller);

        $this->assertEquals(0, $item->likes()->count());

        $this->actingAs($user)->post(route('like.store', $item->id));

        $this->assertEquals(1, $item->likes()->count());
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function いいね済みの場合アイコンの色が変化する()
    {
        $user   = User::factory()->create();
        $seller = User::factory()->create();
        $item   = $this->createItem($seller);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/items/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('icon-heart-pink.png');
    }

    /** @test */
    public function 再度いいねアイコンを押下するといいねが解除されいいね合計値が減少する()
    {
        $user   = User::factory()->create();
        $seller = User::factory()->create();
        $item   = $this->createItem($seller);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $this->assertEquals(1, $item->likes()->count());

        $this->actingAs($user)->post(route('like.store', $item->id));

        $this->assertEquals(0, $item->likes()->count());
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}