<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Profile;
use App\Models\User;
use App\Services\PurchaseService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PurchaseTest extends TestCase
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

    private function createUserWithProfile(): User
    {
        $user = User::factory()->create();
        Profile::factory()->create([
            'user_id'  => $user->id,
            'post_code' => '123-4567',
            'address'  => 'テスト住所',
            'building' => 'テストビル',
        ]);
        return $user;
    }

    /** @test */
    public function 購入するボタンを押下するとStripe決済画面にリダイレクトされる()
    {
        // PurchaseServiceをモックしてStripe APIを呼ばないようにする
        $this->mock(PurchaseService::class, function ($mock) {
            $mock->shouldReceive('createStripeSession')
                ->zeroOrMoreTimes()
                ->andReturn('https://checkout.stripe.com/test');
        });

        $buyer  = $this->createUserWithProfile();
        $seller = User::factory()->create();
        $item   = $this->createItem($seller);

        $response = $this->actingAs($buyer)->post(route('purchase.store', $item->id), [
            'payment_method' => 'card',
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function 購入完了後に商品がSold状態になる()
    {
        Mail::fake();

        $buyer  = $this->createUserWithProfile();
        $seller = User::factory()->create();
        $item   = $this->createItem($seller);

        // セッションに購入情報をセット（success経由の購入を再現）
        $response = $this->actingAs($buyer)
            ->withSession([
                'purchase_item_id' => $item->id,
                'payment_method'   => 'card',
            ])
            ->get(route('purchase.success', $item->id) . '?session_id=dummy');

        $this->assertTrue($item->fresh()->is_sold);
        $this->assertDatabaseHas('orders', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function 購入した商品は商品一覧にてSoldと表示される()
    {
        $item = Item::factory()->create([
            'user_id'      => User::factory()->create()->id,
            'category_id'  => Category::factory()->create()->id,
            'condition_id' => Condition::factory()->create()->id,
            'is_sold'      => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    /** @test */
    public function 購入した商品がプロフィールの購入商品一覧に追加される()
    {
        Mail::fake();

        $buyer  = $this->createUserWithProfile();
        $seller = User::factory()->create();
        $item   = $this->createItem($seller);

        $this->actingAs($buyer)
            ->withSession([
                'purchase_item_id' => $item->id,
                'payment_method'   => 'card',
        ])
        ->get(route('purchase.success', $item->id) . '?session_id=dummy');

        $response = $this->actingAs($buyer)->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee($item->name);
    }

    /** @test */
    public function 支払い方法を選択すると小計画面に反映される()
    {
        $buyer  = $this->createUserWithProfile();
        $seller = User::factory()->create();
        $item   = $this->createItem($seller);

        $response = $this->actingAs($buyer)->get(route('purchase.create', $item->id));

        $response->assertStatus(200);
        $response->assertSee('コンビニ支払い');
        $response->assertSee('カード支払い');
    }
}