<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\DailyReport;
use App\Models\Document;
use App\Models\FinancialReport;
use App\Models\HousingLocation;
use App\Models\ProjectFinance;
use App\Models\User;
use App\Policies\CompanyPolicy;
use App\Policies\DailyReportPolicy;
use App\Policies\DocumentPolicy;
use App\Policies\FinancialReportPolicy;
use App\Policies\HousingLocationPolicy;
use App\Policies\ProjectFinancePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Company::class => CompanyPolicy::class,
        User::class => UserPolicy::class,
        HousingLocation::class => HousingLocationPolicy::class,
        Document::class => DocumentPolicy::class,
        FinancialReport::class => FinancialReportPolicy::class,
        DailyReport::class => DailyReportPolicy::class,
        ProjectFinance::class => ProjectFinancePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
