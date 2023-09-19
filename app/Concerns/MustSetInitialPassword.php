<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Notifications\Admin;
use App\Notifications\Ngo;
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

    public function setPassword(string $password): bool
    {
        return $this->forceFill([
            'password' => Hash::make($password),
            'email_verified_at' => now(),
            'password_set_at' => now(),
        ])->save();
    }

    public function sendWelcomeNotification(): void
    {
        if ($this->isSuperUser()) {
            $this->notify(new Admin\WelcomeNotification());
        }

        if ($this->isOrganizationAdmin()) {
            $this->notify(new Ngo\WelcomeNotification());
        }
    }
}
