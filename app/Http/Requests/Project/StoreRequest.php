<?php

declare(strict_types=1);

namespace App\Http\Requests\Project;

use App\Enums\ProjectStatus;
use Illuminate\Foundation\Http\FormRequest;

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
            'name' => ['string', 'max:255', 'nullable'],
            'target_budget' => ['numeric', 'nullable'],
            'categories' => ['array'],
            'categories.*' => ['nullable', 'exists:project_categories,id'],
            'start' => ['date', 'nullable','after_or_equal:today'],
            'end' => ['date', 'nullable', 'after:tomorrow'],
            'counties' => ['array', 'nullable'],
            'counties.*' => ['exists:counties,id', 'nullable'],
            'description' => ['string', 'nullable', 'max:800'],
            'scope' => ['string', 'nullable'],
            'reason_to_donate' => ['string', 'nullable'],
            'beneficiaries' => ['nullable', 'string'],
            'accepting_volunteers' => ['boolean', 'nullable'],
            'accepting_comments' => ['boolean', 'nullable'],
            'videos' => ['nullable', 'array'],
            'videos.*' => ['nullable', 'url'],
            'external_links' => ['nullable', 'array'],
            'external_links.*' => ['nullable', 'url'],
            'is_national' => ['boolean', 'nullable'],
            'file_group' => ['array', 'nullable'],
            'file_group.*.file' => ['file', 'nullable'],
        ];
    }
}
