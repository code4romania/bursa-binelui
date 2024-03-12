<?php

declare(strict_types=1);

namespace App\Http\Requests\RegionalProject;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isOrganizationAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'gala_id' => ['required', 'exists:galas,id'],
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'youth' => ['nullable', 'boolean'],
            'organization_type' => ['nullable', 'string'],
            'reason' => ['nullable', 'string'],
            'solution' => ['nullable', 'string'],
            'project_details' => ['nullable', 'string'],
            'special' => ['nullable', 'string'],
            'results' => ['nullable', 'string'],
            'proud' => ['nullable', 'string'],
            'partnership' => ['nullable', 'boolean'],
            'partnership_details' => ['nullable', 'string'],
            'budget_details' => ['nullable', 'string'],
            'area' => ['nullable', 'string'],
            'participants' => ['nullable', 'string'],
            'team_details' => ['nullable', 'string'],
            'info_by_email' => ['nullable', 'boolean'],
            'contact' => ['nullable', 'array'],
            'contact.*.name' => ['nullable', 'string'],
            'contact.*.email' => ['nullable', 'email'],
            'contact.*.phone' => ['nullable', 'string'],
            'contact.*.role' => ['nullable', 'string'],
        ];
    }
}
