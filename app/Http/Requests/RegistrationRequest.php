<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\ValidCIF;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'type' => ['required', 'string'],
            'terms' => ['required', 'accepted'],
            'subscribe' => ['boolean'],
            'user' => ['required', 'array'],
            'user.name' => ['required', 'string'],
            'user.email' => ['required', 'email', 'unique:users,email'],
            'user.password' => ['required', 'string', 'confirmed'],
        ];

        if ($this->type === 'organization') {
            $rules = array_merge($rules, [
                'ngo' => ['required', 'array'],
                'ngo.name' => ['required', 'string'],
                'ngo.description' => ['required', 'string', 'max:1000'],
                'ngo.logo' => ['required', 'image'],
                'ngo.statute' => ['required', 'file', 'mimes:pdf', 'max:15240'],
                'ngo.address' => ['required', 'string'],
                'ngo.cif' => ['required', 'string', 'unique:organizations,cif', new ValidCIF],
                'ngo.contact_email' => ['required', 'email'],
                'ngo.contact_phone' => ['nullable', 'string'],
                'ngo.contact_person' => ['required', 'string'],
                'ngo.domains' => ['required', 'array'],
                'ngo.counties' => ['required', 'array'],
                'ngo.volunteer' => ['boolean'],
                'ngo.accepts_volunteers' => ['nullable', 'boolean'],
                'ngo.why_volunteer' => ['string', 'nullable', 'max:1000'],
                'ngo.website' => ['string', 'nullable', 'url'],
            ]);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'ngo.domains' => __('custom_validation.activity_domains_ids'),
            'ngo.counties' => __('custom_validation.counties_ids'),
        ];
    }
}
