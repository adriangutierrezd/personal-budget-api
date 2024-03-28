<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\Category;
use App\Models\EquityStatement;
use App\Models\Expense;
use App\Models\Recurring;
use App\Models\Revenue;
use App\Policies\V1\CategoryPolicy;
use App\Policies\V1\EquityStatementPolicy;
use App\Policies\V1\ExpensePolicy;
use App\Policies\V1\RecurringPolicy;
use App\Policies\V1\RevenuePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Expense::class => ExpensePolicy::class,
        Recurring::class => RecurringPolicy::class,
        Revenue::class => RevenuePolicy::class,
        EquityStatement::class => EquityStatementPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
