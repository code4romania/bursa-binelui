<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Http\Responses\Auth\LoginResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Welcome extends Component implements HasForms
{
    use InteractsWithForms;
    use WithRateLimiting;

    public ?User $user = null;

    public ?string $email = null;

    public ?string $password = null;

    public ?string $passwordConfirmation = null;

    public function mount($user, Request $request): void
    {

        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        if (! $request->hasValidSignature()) {
            abort(Response::HTTP_FORBIDDEN, __('auth.welcome.invalid_signature'));
        }

        $this->user = User::where('id', $user->id)->first();

        if (\is_null($this->user)) {
            abort(Response::HTTP_FORBIDDEN, __('auth.welcome.no_user'));
        }

        if ($this->user->hasSetPassword()) {
            abort(Response::HTTP_FORBIDDEN, __('auth.welcome.already_used'));
        }

        $this->form->fill([
            'email' => $this->user?->email,
        ]);
    }

    public function handle(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            throw ValidationException::withMessages([
                'email' => __('filament::login.messages.throttled', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]),
            ]);
        }

        $this->user->setPassword(data_get($this->form->getState(), 'password'));

        Filament::auth()->login($this->user);

        return app(LoginResponse::class);
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('email')
                ->label(__('filament::login.fields.email.label'))
                ->email()
                ->disabled(),

            TextInput::make('password')
                ->label(__('filament::login.fields.password.label'))
                ->password()
                ->required()
                ->confirmed(),

            TextInput::make('password_confirmation')
                ->label(__('filament::login.fields.password.label'))
                ->password()
                ->required(),
        ];
    }

    public function render(): View
    {
        return view('auth.welcome')
            ->layout('filament::components.layouts.card', [
                'title' => __('filament::login.title'),
            ]);
    }
}
