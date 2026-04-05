<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Like;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    private function createItem(array $overrides = []): Item
    {
        $seller = User::factory()->create();
        $category = Category::factory()->create();
        $condition = Condition::factory()->create();

        return Item::factory()->create(array_merge([
            'user_id'      => $seller->id,
            'category_id'  => $category->id,
            'condition_id' => $condition->id,
        ], $overrides));
    }

    // ===== 商品一覧取得 =====

    /** @test */
    public function 全商品が表示される()
    {
        $this->createItem();
        $this->createItem();

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('items');
    }

    /** @test */
    public function 購入済み商品にSoldラベルが表示される()
    {
        $buyer = User::factory()->create();
        $item = $this->createItem(['is_sold' => true]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /** @test */
    public function ログイン済みユーザーの出品商品は一覧に表示されない()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $condition = Condition::factory()->create();

        $myItem = Item::factory()->create([
            'user_id'      => $user->id,
            'category_id'  => $category->id,
            'condition_id' => $condition->id,
            'name'         => '自分の商品',
        ]);

        $otherItem = $this->createItem(['name' => '他の人の商品']);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('自分の商品');
        $response->assertSee('他の人の商品');
    }

    // ===== マイリスト =====

    /** @test */
    public function マイリストにはいいねした商品のみ表示される()
    {
        $user = User::factory()->create();
        $likedItem = $this->createItem(['name' => 'いいね商品']);
        $notLikedItem = $this->createItem(['name' => 'いいねなし商品']);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('いいね商品');
        $response->assertDontSee('いいねなし商品');
    }

    /** @test */
    public function マイリストの購入済み商品にSoldラベルが表示される()
    {
        $user = User::factory()->create();
        $item = $this->createItem(['is_sold' => true]);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /** @test */
    public function 未認証の場合マイリストに何も表示されない()
    {
        $item = $this->createItem();

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertViewHas('items', function ($items) {
            return $items->isEmpty();
        });
    }

    // ===== 商品検索 =====

    /** @test */
    public function キーワードで部分一致検索ができる()
    {
        $this->createItem(['name' => 'コーヒーミル']);
        $this->createItem(['name' => '自転車']);

        $response = $this->get('/?keyword=コーヒー');

        $response->assertStatus(200);
        $response->assertSee('コーヒーミル');
        $response->assertDontSee('自転車');
    }

    /** @test */
    public function 検索状態がマイリストでも保持されている()
    {
        $user = User::factory()->create();
        $item = $this->createItem(['name' => 'コーヒーミル']);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=コーヒー');

        $response->assertStatus(200);
        $response->assertSee('コーヒーミル');
    }

    // ===== 商品詳細 =====

    /** @test */
    public function 商品詳細ページに必要な情報が表示される()
    {
        $item = $this->createItem(['name' => 'テスト商品', 'price' => 1000]);

        $response = $this->get('/items/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
        $response->assertSee('1,000');
    }

    /** @test */
    public function 未認証ユーザーでも商品詳細を確認できる()
    {
        $item = $this->createItem(['name' => 'テスト商品']);

        $response = $this->get('/items/' . $item->id);

        $response->assertStatus(200);
        $response->assertSee('テスト商品');
    }
}