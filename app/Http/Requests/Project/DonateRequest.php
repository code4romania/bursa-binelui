<?php

declare(strict_types=1);

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class DonateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric', 'min:' . config('app.min_donation'), 'max:' . config('app.max_donation')],
            'terms' => ['required', 'accepted'],
            'email' => ['required', 'email'],
            'name' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.min' => __('custom_validation.project.donate.min', ['min' => config('app.min_donation')]),
            'amount.max' => __('custom_validation.project.donate.max', ['max' => config('app.max_donation')]),
        ];
    }
}
