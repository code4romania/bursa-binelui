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
            'type' => ['string', 'required'],
            'user' => ['array', 'required'],
            'user.name' => ['string', 'required'],
            'user.email' => ['email', 'required', 'unique:users,email'],
            'user.password' => ['string', 'required', 'confirmed'],
        ];

        if ($this->type === 'organization') {
            $rules = array_merge($rules, [
                'ngo' => ['array', 'required'],
                'ngo.name' => ['string', 'required'],
                'ngo.description' => ['string', 'required'],
                'ngo.logo' => ['required', 'image'],
                'ngo.statute' => ['required', 'file'],
                'ngo.street_address' => ['string', 'required'],
                'ngo.cif' => ['string', 'required', 'unique:organizations,cif', new ValidCIF],
                'ngo.contact_email' => ['required', 'email'],
                'ngo.contact_phone' => ['string', 'required'],
                'ngo.contact_person' => ['string', 'required'],
                'ngo.domains' => ['array', 'required'],
                'ngo.counties' => ['array', 'required'],
                'ngo.volunteer' => ['boolean'],
                'ngo.why_volunteer' => ['string', 'nullable'],
                'ngo.website' => ['string', 'nullable'],
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
