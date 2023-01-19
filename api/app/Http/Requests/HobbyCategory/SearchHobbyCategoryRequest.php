<?php

namespace App\Http\Requests\HobbyCategory;

use Illuminate\Foundation\Http\FormRequest;

class SearchHobbyCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'q' =>  'nullable|string|max:255',
            'perPage' => 'nullable|int|max:100',
            'page'    =>  'nullable|int'
        ];
    }
}
