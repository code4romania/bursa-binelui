<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isNgoAdmin();
    }

    public function rules(): array
    {
        return [
            'content' => ['required', 'string'],
        ];
    }
}
