<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug,' . $this->route('project')?->id],
            'project_category_id' => ['nullable', 'exists:project_categories,id'],
            'description' => ['required', 'string'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
            'status' => ['in:draft,published,archived'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'project_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_featured' => ['boolean'],
            'sort_order' => ['integer', 'min:0'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id'],
            'technologies' => ['nullable', 'array'],
            'technologies.*' => ['string', 'max:100'],
        ];
    }
}
