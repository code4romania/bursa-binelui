<?php

declare(strict_types=1);

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class EditRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        if ($this->has('external_links')) {
            $this->merge([
                'external_links' => $this->appendHttpsToUrl($this->external_links),
            ]);
        }

        if ($this->has('videos')) {
            $this->merge([
                'videos' => $this->appendHttpsToUrl($this->videos),
            ]);
        }
    }

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
            'description' => ['string', 'nullable', 'max:1000'],
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
//            TODO to check how we can validate this. Problema e ca validate nu stie sa ia mix intre File si array
//            'gallery.*.file' => ['nullable', 'image', 'max:5120'],
//            'gallery.*.id' => ['nullable', 'exists:media,id'],
//            'gallery.*.url' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
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

    private function appendHttpsToUrl(array $data): array
    {
        return collect($data)->map(function ($item) {
            if (! filled($item['url'])) {
                return $item;
            }
            if (Str::isUrl($item['url'])) {
                return $item;
            }
            $item['url'] = 'https://' . $item['url'];

            return $item;
        })->toArray();
    }
}
