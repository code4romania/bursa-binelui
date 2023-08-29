<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            $rules['ong'] = ['array', 'required'];
            $rules['ong.name'] = ['string', 'required'];
            $rules['ong.description'] = ['string', 'required'];
            $rules['ong.logo'] = ['required', 'file'];
            $rules['ong.statute'] = ['required', 'file'];
            $rules['ong.street_address'] = ['string', 'required'];
            $rules['ong.cif'] = ['string', 'required'];
            $rules['ong.contact_email'] = ['required', 'email'];
            $rules['ong.contact_phone'] = ['string', 'required'];
            $rules['ong.contact_person'] = ['string', 'required'];
            $rules['ong.activity_domains_ids'] = ['array', 'required'];
            $rules['ong.counties_ids'] = ['array', 'required'];
            $rules['ong.volunteer'] = ['boolean'];
            $rules['ong.why_volunteer'] = ['string','nullable'];
            $rules['ong.website'] = ['string','nullable'];
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
