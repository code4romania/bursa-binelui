<?php

declare(strict_types=1);

namespace App\Http\Requests\Organization;

use App\Rules\ValidCIF;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationRequest extends FormRequest
{
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
            'logo' => ['nullable', 'image', 'max:2048'],
            'statute' => ['nullable', 'file', 'mimes:pdf', 'max:15360'],
            'address' => ['nullable', 'string'],
            'cif' => ['nullable', 'string', 'unique:organizations,cif', new ValidCIF],
            'contact_email' => ['nullable', 'email'],
            'contact_phone' => ['nullable', 'string'],
            'contact_person' => ['nullable', 'string'],
            'activity_domains' => ['nullable', 'array'],
            'counties' => ['nullable', 'array'],
            'volunteer' => ['nullable', 'boolean'],
            'accepts_volunteers' => ['nullable', 'boolean'],
            'why_volunteer' => ['nullable', 'string'],
            'website' => ['nullable', 'string'],
        ];
    }
}
