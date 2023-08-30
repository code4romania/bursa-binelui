<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use App\Rules\ValidCIF;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->organization);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'logo' => ['file', 'nullable'],
            'statute' => ['file', 'nullable'],
            'street_address' => ['nullable', 'string'],
            'cif' => ['nullable', 'string', 'unique:organizations,cif', new ValidCIF],
            'contact_email' => ['nullable', 'email'],
            'contact_phone' => ['nullable', 'string'],
            'contact_person' => ['nullable', 'string'],
            'activity_domains_ids' => ['nullable', 'array'],
            'counties_ids' => ['nullable', 'array'],
            'volunteer' => ['nullable','boolean'],
            'why_volunteer' => ['nullable', 'string'],
            'website' => ['nullable', 'string'],
        ];
    }
}
