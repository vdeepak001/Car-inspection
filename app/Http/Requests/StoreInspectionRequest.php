<?php

namespace App\Http\Requests;

use App\Models\Inspection;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInspectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'brand' => ['required', 'string', 'max:100'],
            'model_name' => ['required', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:100'],
            'inspector' => ['required', 'string', 'max:255'],
            'vin' => ['required', 'string', 'max:50'],
            'engine_number' => ['nullable', 'string', 'max:50'],
            'inspected_on' => ['required', 'date'],
            'items' => ['required', 'array'],
        ];

        foreach (Inspection::checklistItems() as $key => $item) {
            $rules["items.{$key}.score"] = ['required', 'integer', 'between:1,10'];
        }

        return $rules;
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $messages = [];

        foreach (Inspection::checklistItems() as $key => $item) {
            $messages["items.{$key}.score.required"] = "Rate {$item['label']} out of 10.";
        }

        return $messages;
    }
}
