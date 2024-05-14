<?php

declare(strict_types=1);

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class EditRequest extends FormRequest
{
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
            'start' => ['date', 'nullable', 'after_or_equal:today'],
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
            'videos.*.url' => ['required', 'url'],
            'external_links' => ['nullable', 'array'],
            'external_links.*.title' => ['required', 'string'],
            'external_links.*.url' => ['required', 'url'],
            'is_national' => ['boolean', 'nullable'],
            'gallery' => ['array', 'nullable'],
            'gallery.*.file' => ['file', 'nullable', File::image()->max(5000)->extensions(['png', 'jpg', 'jpeg'])],
            'image' => ['file', File::image()->max('5mb')->extensions(['png', 'jpg', 'jpeg']), 'nullable'],
        ];
    }

    public function messages(): array
    {
        return[
            'start.after_or_equal' => __('custom_validation.project.start.after_or_equal'),
            'end.after' => __('custom_validation.project.end.after'),
            'videos.*.url.url' => __('custom_validation.url'),
            'image.max' => __('custom_validation.image.size'),
            'gallery.*.file.max' => __('custom_validation.image.size'),
        ];
    }
}
