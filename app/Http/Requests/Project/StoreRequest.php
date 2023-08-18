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
//        if ($this->project_status === ProjectStatus::pending->value) {
//            return [
//                'name' => ['required', 'string', 'max:255'],
//                'target_budget' => ['required', 'numeric'],
//                'start' => ['required', 'date'],
//                'end' => ['required', 'date'],
//                'categories' => ['required', 'array'],
//                'categories.*' => ['required', 'exists:project_categories,id'],
//                'counties' => ['array'],
//                'counties.*' => ['required', 'exists:counties,id'],
//                'description' => ['required', 'string'],
//                'scope' => ['required', 'string'],
//                'reason_to_donate' => ['required', 'string'],
//                'beneficiaries' => ['required', 'string'],
//                'accepting_volunteers' => ['required', 'boolean'],
//                'accepting_comments' => ['required', 'boolean'],
//                'videos' => ['nullable', 'array'],
//                'videos.*' => ['nullable', 'url'],
//                'external_links' => ['nullable', 'array'],
//                'external_links.*' => ['nullable', 'url'],
//                'is_national' => ['required', 'boolean'],
//                'file_group' => ['required', 'array'],
//                'file_group.*.file' => ['required', 'file'],
//            ];
//        }

        return [
            'name' => ['string', 'max:255', 'nullable'],
            'target_budget' => ['numeric', 'nullable'],
            'categories' => ['array'],
            'categories.*' => ['nullable', 'exists:project_categories,id'],
            'start' => ['date', 'nullable'],
            'end' => ['date', 'nullable'],
            'counties' => ['array', 'nullable'],
            'counties.*' => ['exists:counties,id', 'nullable'],
            'description' => ['string', 'nullable'],
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
