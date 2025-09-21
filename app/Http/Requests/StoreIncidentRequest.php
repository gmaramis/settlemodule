<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Incident;

class StoreIncidentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization is handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'department' => 'required|string|in:' . implode(',', Incident::getDepartments()),
            'event_type' => 'required|string|in:' . implode(',', Incident::getEventTypes()),
            'event_type_explanation' => 'nullable|string|max:1000',
            'incident_date' => 'required|date|before_or_equal:tomorrow',
            'what_happened' => 'required|string|min:10|max:2000',
            'why_did_it_happen' => 'required|string|min:10|max:2000',
            'contributing_factors' => 'nullable|array',
            'contributing_factors.*' => 'string|in:' . implode(',', Incident::getContributingFactors()),
            'outcome' => 'required|string|in:' . implode(',', Incident::getOutcomes()),
            'prevention_suggestions' => 'nullable|string|max:2000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'what_happened.required' => 'Please describe what happened in detail.',
            'what_happened.min' => 'The description must be at least 10 characters long.',
            'why_did_it_happen.required' => 'Please provide a system analysis of why this happened.',
            'why_did_it_happen.min' => 'The analysis must be at least 10 characters long.',
            'department.required' => 'Please select a clinical department.',
            'event_type.required' => 'Please select the type of event.',
            'outcome.required' => 'Please select the outcome of the incident.',
            'incident_date.before_or_equal' => 'Tanggal insiden tidak boleh di masa depan. Pastikan tanggal yang Anda masukkan adalah hari ini atau sebelumnya.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'event_type_explanation' => 'event type explanation',
            'incident_date' => 'incident date and time',
            'what_happened' => 'what happened',
            'why_did_it_happen' => 'why did it happen',
            'contributing_factors' => 'contributing factors',
            'prevention_suggestions' => 'prevention suggestions',
        ];
    }
}
