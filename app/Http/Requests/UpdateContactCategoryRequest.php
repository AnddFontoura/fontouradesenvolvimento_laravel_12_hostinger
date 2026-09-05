<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateContactCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('contact_categories', 'name')->ignore($categoryId),
            ],
            'color' => ['required', Rule::in($this->allowedColors())],
        ];
    }

    /**
     * Colors accepted for a category badge.
     *
     * @return list<string>
     */
    protected function allowedColors(): array
    {
        return ['gray', 'orange', 'blue', 'green', 'purple', 'red', 'yellow'];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Informe o nome da categoria.',
            'name.unique' => 'Já existe uma categoria com esse nome.',
            'color.in' => 'Selecione uma cor válida.',
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'color' => 'cor',
        ];
    }
}
