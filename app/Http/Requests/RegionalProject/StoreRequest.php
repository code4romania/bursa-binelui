<?php

declare(strict_types=1);

namespace App\Http\Requests\RegionalProject;

use App\Enums\ProjectStatus;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->isOrganizationAdmin();
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
//                'project_status' => ['required', 'string'], // 'pending' or 'approved
//                'name' => ['required', 'string', 'max:255'],
//                'description' => ['required', 'string'],
//                'start_date' => ['required', 'date'],
//                'end_date' => ['required', 'date'],
//                'for_youth' => ['required', 'boolean'],
//                'identified_need' => ['required', 'string'],
//                'proposed_solution' => ['required', 'string'],
//                'project_progress' => ['required', 'string'],
//                'project_differentiator' => ['required', 'string'],
//                'key_results' => ['required', 'string'],
//                'pride_success' => ['required', 'string'],
//                'had_partners' => ['required', 'boolean'],
//                'partners' => ['required_if:had_partners,true', 'string','nullable'],
//                'project_budget' => ['required', 'string'],
//                'impact_area' => ['required', 'string'],
//                'participant_count' => ['required', 'string'],
//                'project_team' => ['required', 'string'],
//                'info_sources' => ['required', 'string'],
//                'contact_info' => ['required', 'array'],
//                'contact_info.name' => ['required', 'string'],
//                'contact_info.email' => ['required', 'email'],
//                'contact_info.phone' => ['required', 'string'],
//                'contact_info.job' => ['required', 'string'],
//            ];
//        }
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'for_youth' => ['nullable', 'boolean'],
            'identified_need' => ['nullable', 'string'],
            'proposed_solution' => ['nullable', 'string'],
            'project_progress' => ['nullable', 'string'],
            'project_differentiator' => ['nullable', 'string'],
            'key_results' => ['nullable', 'string'],
            'pride_success' => ['nullable', 'string'],
            'had_partners' => ['nullable', 'boolean'],
            'partners' => ['nullable', 'string'],
            'project_budget' => ['nullable', 'string'],
            'impact_area' => ['nullable', 'string'],
            'participant_count' => ['nullable', 'string'],
            'project_team' => ['nullable', 'string'],
            'info_sources' => ['nullable', 'string'],
            'contact_info' => ['nullable', 'array'],
            'contact_info.*.name' => ['nullable', 'string'],
            'contact_info.*.email' => ['nullable', 'email'],
            'contact_info.*.phone' => ['nullable', 'string'],
            'contact_info.*.role' => ['nullable', 'string'],
            'contact_info.*.organization' => ['nullable', 'string'],
        ];
    }
}
