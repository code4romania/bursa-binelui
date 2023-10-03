<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $credentials = $this->only('email', 'password');
        $remember = $this->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            RateLimiter::clear($this->throttleKey());

            return;
        }

        RateLimiter::hit($this->throttleKey());

        $user = User::firstWhere('email', $this->email);

        if ($this->hasValidOldCredentials($user, $credentials)) {
            Auth::login($user);

            $user->forceFill([
                'password' => Hash::make($this->password),
                'old_password' => null,
                'old_salt' => null,
            ])->save();

            return;
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('email')) . '|' . $this->ip());
    }

    protected function hasValidOldCredentials(?User $user, array $credentials): bool
    {
        return auth()->guard()->getTimebox()->call(function ($timebox) use ($user, $credentials) {
            $validated = (
                ! \is_null($user) &&
                ! \is_null($plain = $credentials['password']) &&
                ! \is_null($user->old_password) &&
                ! \is_null($user->old_salt) &&
                false !== ($old_hash = base64_decode($user->old_password, true)) &&
                false !== ($old_salt = base64_decode($user->old_salt, true)) &&
                hash_equals($old_hash, hash('sha256', $plain . $old_salt, true))
            );

            if ($validated) {
                $timebox->returnEarly();
            }

            return $validated;
        }, 200 * 1000);
    }
}
