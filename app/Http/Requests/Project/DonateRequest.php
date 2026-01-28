<?php

declare(strict_types=1);

namespace App\Http\Requests\Project;

use App\Models\Setting;
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
        $min = (int) (Setting::value('donation_min_amount') ?? config('app.min_donation', 5));
        $max = (int) (Setting::value('donation_max_amount') ?? config('app.max_donation', 1000));

        return [
            'amount' => ['required', 'numeric', 'min:' . $min, 'max:' . $max],
            'terms' => ['required', 'accepted'],
            'email' => ['required', 'email'],
            'name' => ['required'],
        ];
    }

    public function messages(): array
    {
        $min = (int) (Setting::value('donation_min_amount') ?? config('app.min_donation', 5));
        $max = (int) (Setting::value('donation_max_amount') ?? config('app.max_donation', 1000));

        return [
            'amount.min' => __('custom_validation.project.donate.min', ['min' => $min]),
            'amount.max' => __('custom_validation.project.donate.max', ['max' => $max]),
        ];
    }
}
