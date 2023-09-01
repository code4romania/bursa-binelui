<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Enums\UserRole;
use App\Notifications\Admin\WelcomeNotification as AdminWelcomeNotification;
use App\Notifications\Ngo\WelcomeNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait MustSetInitialPassword
{
    protected static function bootMustSetInitialPassword(): void
    {
        static::creating(function (self $user) {
            if (! $user->password) {
                $user->password = Hash::make(Str::random(128));
            }
        });

        static::created(function (self $user) {
            if (! app()->runningInConsole()) {
                if (! empty($user->created_by)) {
                    $user->sendWelcomeNotification();
                }
            }
        });
    }

    public function hasSetPassword(): bool
    {
        return ! \is_null($this->password_set_at);
    }

    public function markPasswordAsSet(): bool
    {
        return $this->forceFill([
            'password_set_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function sendWelcomeNotification(): void
    {
        if ($this->role === UserRole::ngo_admin) {
            $this->notify(new WelcomeNotification());

            return;
        }
        $this->notify(new AdminWelcomeNotification());
    }
}
