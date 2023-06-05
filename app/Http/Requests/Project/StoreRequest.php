<?php

declare(strict_types=1);

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //TODO: check if user is admin organization or organization member
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'target_budget' => ['required', 'numeric'],
            'start' => ['required', 'date'],
            'end' => ['required', 'date'],
            'county'=> [Rule::requiredIf(function(){ return $this->is_national === false;})],
            'description' => ['required', 'string'],
            'scope' => ['required', 'string'],
            'reason_to_donate' => ['required', 'string'],
            'beneficiaries' => ['required', 'string'],
            'accepting_volunteers' => ['required', 'boolean'],
            'accepting_comments' => ['required', 'boolean'],
            'videos' => ['nullable', 'array'],
            'videos.*' => ['nullable', 'url'],
            'external_links' => ['nullable', 'array'],
            'external_links.*' => ['nullable', 'url'],
            'county_id' => ['nullable', 'exists:counties,id'],
            'is_national' => ['required', 'boolean'],
            'file_group'=> ['required', 'array'],
            'file_group.*.file'=> ['required', 'file'],
        ];
    }
}
