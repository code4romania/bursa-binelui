<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\ValidCIF;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

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
            'user.password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),

            ],
        ];

        if ($this->type === 'organization') {
            $rules = array_merge($rules, [
                'ngo' => ['required', 'array'],
                'ngo.name' => ['required', 'string'],
                'ngo.description' => ['required', 'string', 'max:1000'],
                'ngo.logo' => ['required', 'image', 'max:2048'],
                'ngo.statute' => ['required', 'file', 'mimes:pdf', 'max:15360'],
                'ngo.address' => ['required', 'string'],
                'ngo.cif' => ['required', 'string', 'unique:organizations,cif', new ValidCIF],
                'ngo.contact_email' => ['required', 'email'],
                'ngo.contact_phone' => ['required', 'string'],
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
            'user.email.unique' => __('custom_validation.email_unique'),
            'user.password.confirmed' => __('custom_validation.password_confirmed'),
            'user.password.*' => __('custom_validation.password_complexity'),
            'terms.accepted' => __('custom_validation.terms_required'),
            'ngo.cif.unique' => __('custom_validation.ngo.cif.unique'),
            'ngo.logo.required' => __('custom_validation.ngo.field.required', ['attribute' => 'logo']),
            'ngo.cif.required' => __('custom_validation.ngo.field.required', ['attribute' => 'cif']),
            'ngo.description.required' => __('custom_validation.ngo.field.required', ['attribute' => 'description']),
            'ngo.statute.required' => __('custom_validation.ngo.field.required', ['attribute' => 'statut']),
            'ngo.address.required' => __('custom_validation.ngo.field.required', ['attribute' => 'adresa']),
            'ngo.contact_email.required' => __('custom_validation.ngo.field.required', ['attribute' => 'email contact']),
            'ngo.contact_phone.required' => __('custom_validation.ngo.field.required', ['attribute' => 'telefon contact']),
            'ngo.contact_person.required' => __('custom_validation.ngo.field.required', ['attribute' => 'persoana de contact']),
            'ngo.website.url' => __('custom_validation.ngo.field.url', ['attribute' => 'Website']),

        ];
    }
}
