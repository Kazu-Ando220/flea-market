<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::loginView(fn () => view('auth.login'));
        Fortify::registerView(fn ()  => view('auth.register'));
        Fortify::verifyEmailView(fn()  => view('auth.verify-email'));

        $this->app->instance(
            \Laravel\Fortify\Contracts\RegisterResponse::class,
            new class implements \Laravel\Fortify\Contracts\RegisterResponse {
                public function toResponse($request)
                {
                    return redirect()->route('verification.notice')
                        ->with('success', '会員登録が完了しました。送信されたメールから本登録を完了させてください。');
                }
            }
        );

        $this->app->instance(
            \Laravel\Fortify\Contracts\VerifyEmailResponse::class,
            new class implements \Laravel\Fortify\Contracts\VerifyEmailResponse {
                public function toResponse($request)
                {
                    return redirect('/mypage/profile')
                        ->with('success', 'メール認証が完了しました。プロフィールの設定をお願いします。');
                }
            }
        );

        $this->app->instance(
            \Laravel\Fortify\Contracts\LoginResponse::class,
            new class implements \Laravel\Fortify\Contracts\LoginResponse {
                public function toResponse($request)
                {
                    return redirect('/')
                        ->with('success', 'ログインしました。');
                }
            }
        );

        $this->app->instance(
            \Laravel\Fortify\Contracts\LogoutResponse::class,
            new class implements \Laravel\Fortify\Contracts\LogoutResponse {
                public function toResponse($request)
                {
                    return redirect('/')
                        ->with('success', 'ログアウトしました。');
                }
            }
        );

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . $request->ip());
        });
    }
}