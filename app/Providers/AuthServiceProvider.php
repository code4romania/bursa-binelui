<?php

declare(strict_types=1);

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Organization;
use App\Models\Project;
use App\Policies\OrganizationPolicy;
use App\Policies\ProjectPolicy;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\HtmlString;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Organization::class => OrganizationPolicy::class,
        Project::class => ProjectPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('view-project', function ($user) {
            return $user->isAdmin();
        });
        app()->setLocale('ro');
        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject(__('auth.mail.verify_email.subject'))
                ->greeting(__('auth.mail.verify_email.greeting'))
                ->line(__('auth.mail.verify_email.line_1'))
                ->salutation(
                    new HtmlString(__('mail.salutation') . '<br/>' . __('mail.team'))
                )
                ->action(__('auth.mail.verify_email.action'), $url);
        });
    }
}
