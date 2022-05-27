<?php

namespace App\Providers;

use App\Models\School;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Thesis;
use App\Models\User;
use App\Policies\SchoolPolicy;
use App\Policies\ThesisPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Thesis::class => ThesisPolicy::class,
        School::class => SchoolPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('admin', function (User $user) {
          return $user->is_admin;
      });
    }
}
