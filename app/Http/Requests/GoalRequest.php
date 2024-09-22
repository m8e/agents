<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:255'],
            'deadline_date' => ['nullable', 'date'],
            'team_id' => ['required', 'exists:teams,id'],
            'user_id' => ['required', 'exists:users,id'],
            'agent_id' => ['nullable', 'exists:agents,id'],
            'start_date' => ['required', 'date'],
            'progress' => ['required', 'integer', 'min:0', 'max:100'],
            'status' => ['required', 'in:not_started,in_progress,completed'],
            'priority' => ['required', 'in:critical,high,normal,low,backlog'],
            'risk_level' => ['required', 'in:low,medium,high'],
            'estimated_tokens' => ['nullable', 'integer', 'min:0'],
            'actual_tokens' => ['nullable', 'integer', 'min:0'],
            'outcome' => ['nullable', 'string'],
            'tags' => ['nullable', 'string'],
            'completion_criteria' => ['nullable', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
