<?php

namespace App\Providers;

use App\Models\Wg;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->configureDefaults();
        $this->registerObservers();
        $this->shareDataWithViews();
    }

    protected function shareDataWithViews(): void
    {
        // Share user's WGs with all views for the sidebar dropdown
        View::composer('*', function ($view) {
            if (auth()->check()) {
                $wgs = Wg::where('owner_user_id', auth()->id())->get();
                $wg = auth()->user()->activeWg ?? $wgs->first();
                
                $view->with([
                    'wgs' => $wgs,
                    'wg' => $wg,
                ]);
            }
        });
    }

    protected function registerObservers(): void
    {
        \App\Models\CaseModel::observe(\App\Observers\CaseObserver::class);
    }

    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null
        );
    }
}
