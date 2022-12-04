<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LoginResponse;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Laravel\Fortify\Contracts\LogoutResponse;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $request = request();
        if ($request->is('admin/*')) {
            Config::set('fortify.guard', 'admin');
            Config::set('fortify.passwords', 'admins');
            Config::set('fortify.prefix', 'admin');
            // Config::set('fortify.home', 'admin/dashboard');
        }elseif ($request->is('instructor/*')) {
            Config::set('fortify.guard', 'instructor');
            Config::set('fortify.passwords', 'instructor');
            Config::set('fortify.prefix', 'instructor');
                        Config::set('fortify.home', 'instructor/dashboard');

        }
        $this->app->instance(LoginResponse::class, new class implements LoginResponse
        {
            public function toResponse($request)
            {
                if ($request->user('admin')) {
                    return redirect()->intended('admin/dashboard');
                }
                return redirect()->intended('/');
            }
        });

        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse
        {
            public function toResponse($request)
            {
                if ($request->is('admin/*')) {
                    return redirect()->route('admin.dashboard');
                } elseif ($request->is('instructor/*')) {
                    return redirect()->route('instructor.dashboard');
                } else {
                    return redirect('/');
                }
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        if (Config::get('fortify.guard') == 'admin') {
            Fortify::loginView('Auth.login');
            Fortify::registerView('Auth.error404');
        }elseif (Config::get('fortify.guard') == 'instructor'){
            Fortify::loginView('loginA');
            Fortify::registerView('Auth.error404');
        } else {
            Fortify::loginView('loginA');
        }
    }
}
