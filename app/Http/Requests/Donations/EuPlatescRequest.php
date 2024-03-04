<?php

namespace App\Http\Requests\Donations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EuPlatescRequest extends FormRequest
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
            'amount'     => ['required', 'decimal:2'],
            'curr'       => ['required', 'string'],
            'invoice_id' => ['required', 'string'],
            'ep_id'      => ['required', 'string'],
            'merch_id'   => ['required', 'string'],
            'action'     => ['required', 'numeric', Rule::in(0, 1)],
            'message'    => ['required', 'string'],
            'approval'   => ['required', 'string'],
            'timestamp'  => ['required', 'date_format:YmdHis'],
            'nonce'      => ['required', 'string'],
            'fp_hash'    => ['required', 'string'],
            'sec_status' => ['nullable', 'numeric'],
            'rrn' => ['nullable', 'numeric'],
            'mcard' => ['nullable', 'numeric'],
            'card_exp' => ['nullable', 'numeric'],
            'discount_amount' => ['nullable', 'numeric'],
            'card_type' => ['nullable', 'string'],
            'bin' => ['nullable', 'numeric'],
            'rate' => ['nullable', 'string'],
            'card_holder' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
            'rtype' => ['nullable', 'string'],
            'cce' => ['nullable', 'string']
        ];
    }
}
