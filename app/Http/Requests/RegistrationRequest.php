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

        if ($this->type === 'ngo-admin') {
            $rules = array_merge($rules, [
                'ong' => ['array', 'required'],
                'ong.name' => ['string', 'required'],
                'ong.description' => ['string', 'required'],
                'ong.logo' => ['required', 'file'],
                'ong.statute' => ['required', 'file'],
                'ong.street_address' => ['string', 'required'],
                'ong.cif' => ['string', 'required', 'unique:organizations,cif', new ValidCIF],
                'ong.contact_email' => ['required', 'email'],
                'ong.contact_phone' => ['string', 'required'],
                'ong.contact_person' => ['string', 'required'],
                'ong.activity_domains_ids' => ['array', 'required'],
                'ong.counties_ids' => ['array', 'required'],
                'ong.volunteer' => ['boolean'],
                'ong.why_volunteer' => ['string', 'nullable'],
                'ong.website' => ['string', 'nullable'],
            ]);
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'ong.activity_domains_ids' => __('custom_validation.activity_domains_ids'),
            'ong.counties_ids' => __('custom_validation.counties_ids'),
        ];
    }
}
