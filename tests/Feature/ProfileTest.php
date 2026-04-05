<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Condition;
use App\Models\Item;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private function createUserWithProfile(): User
    {
        $user = User::factory()->create(['name' => 'テストユーザー']);
        Profile::factory()->create([
            'user_id'   => $user->id,
            'post_code' => '123-4567',
            'address'   => 'テスト住所',
            'building'  => 'テストビル',
        ]);
        return $user;
    }

    private function createItem(User $seller, array $overrides = []): Item
    {
        return Item::factory()->create(array_merge([
            'user_id'      => $seller->id,
            'category_id'  => Category::factory()->create()->id,
            'condition_id' => Condition::factory()->create()->id,
        ], $overrides));
    }

    // ===== ユーザー情報取得 =====

    /** @test */
    public function プロフィール画面に必要な情報が表示される()
    {
        $user = $this->createUserWithProfile();
        $this->createItem($user, ['name' => '出品商品A']);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('出品商品A');
    }

    // ===== ユーザー情報変更 =====

    /** @test */
    public function プロフィール編集画面に現在の登録情報が初期値として表示される()
    {
        $user = $this->createUserWithProfile();

        $response = $this->actingAs($user)->get('/mypage/profile');

        $response->assertStatus(200);
        $response->assertSee('テストユーザー');
        $response->assertSee('123-4567');
        $response->assertSee('テスト住所');
    }

    // ===== 出品商品情報登録 =====

    /** @test */
    public function 商品出品画面で必要な情報を入力すると商品が保存される()
    {
        Storage::fake('public');

        $user      = $this->createUserWithProfile();
        $category  = Category::factory()->create();
        $condition = Condition::factory()->create();

        // jpeg→pngに変更、サイズ指定なしでGDを使わない
        $file = UploadedFile::fake()->image('test.png');

        $response = $this->actingAs($user)->post('/sell', [
            'img_url'      => $file,
            'category_id'  => $category->id,
            'condition_id' => $condition->id,
            'name'         => 'テスト商品',
            'brand'        => 'テストブランド',
            'description'  => 'テスト説明文',
            'price'        => 1000,
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('items', [
            'user_id'      => $user->id,
            'name'         => 'テスト商品',
            'price'        => 1000,
        ]);
    }
}