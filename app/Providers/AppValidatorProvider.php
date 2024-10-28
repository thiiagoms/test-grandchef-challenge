<?php

namespace App\Providers;

use App\Contracts\Validators\UuidValidatorContract;
use App\Validators\UuidValidator;
use Illuminate\Support\ServiceProvider;

class AppValidatorProvider extends ServiceProvider
{
    private array $validators = [
        UuidValidatorContract::class => UuidValidator::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach ($this->validators as $contract => $validator) {
            $this->app->singleton($contract, $validator);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
