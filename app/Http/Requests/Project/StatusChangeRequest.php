<?php

declare(strict_types=1);

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StatusChangeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'start' => ['required', 'date', 'after_or_equal:today'],
            'end' => ['required', 'date', 'after:start'],
            'target_budget' => ['required', 'numeric', 'min:1'],
            'categories' => ['required', 'array', 'min:1'],
            'counties' => ['required_if:is_national,0', 'array', 'nullable'],
            'description' => ['required', 'min:100', 'max:1000'],
            'scope' => ['required', 'min:100', 'max:1000'],
            'beneficiaries' => ['required', 'min:50', 'max:1000'],
            'reason_to_donate' => ['required', 'min:50', 'max:1000'],
            'preview' => ['required'],
            'videos' => ['nullable', 'array'],
            'videos.*.url' => ['nullable', 'url'],
            'external_links' => ['nullable', 'array'],
            'external_links.*.url' => ['nullable', 'url'],
        ];
    }

    public function messages(): array
    {
        return [
            'start.after_or_equal' => __('custom_validation.start_date.after_or_equal'),
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge($this->project->toArray());

        $this->merge([
            'preview' => $this->project->getFirstMedia('preview'),
        ]);
    }
}
