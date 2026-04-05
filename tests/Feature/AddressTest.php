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

class AddressTest extends TestCase
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
            'user_id'   => $user->id,
            'post_code' => '123-4567',
            'address'   => '元の住所',
            'building'  => '元のビル',
        ]);
        return $user;
    }

    /** @test */
    public function 送付先住所変更画面で登録した住所が商品購入画面に反映される()
    {
        $user   = $this->createUserWithProfile();
        $seller = User::factory()->create();
        $item   = $this->createItem($seller);

        // 住所を変更
        $this->actingAs($user)->patch(route('address.update', $item->id), [
            'post_code' => '987-6543',
            'address'   => '新しい住所',
            'building'  => '新しいビル',
        ]);

        // 購入画面に反映されているか確認
        $response = $this->actingAs($user)->get(route('purchase.create', $item->id));

        $response->assertStatus(200);
        $response->assertSee('新しい住所');
    }

    /** @test */
    public function 購入した商品に送付先住所が紐づいて登録される()
    {
        Mail::fake();

        $this->mock(PurchaseService::class, function ($mock) {
            $mock->shouldReceive('createStripeSession')
                ->zeroOrMoreTimes()
                ->andReturn('https://checkout.stripe.com/test');
            $mock->shouldReceive('completePurchase')
                ->zeroOrMoreTimes()
            ->andReturnUsing(function ($item, $paymentMethod, $userId) {
                $item->purchase(['payment_method' => $paymentMethod], $userId);
            });
        });

        $user   = $this->createUserWithProfile();
        $seller = User::factory()->create();
        $item   = $this->createItem($seller);

        // 住所を変更
        $this->actingAs($user)->patch(route('address.update', $item->id), [
            'post_code' => '987-6543',
            'address'   => '新しい住所',
            'building'  => '新しいビル',
        ]);

        // success経由で購入完了（actingAsの前にwithSessionを設定）
        $this->actingAs($user)
            ->withSession([
                'payment_method' => 'card',
            ])
            ->get(route('purchase.success', $item->id) . '?session_id=dummy');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'address' => '新しい住所',
        ]);
    }
}