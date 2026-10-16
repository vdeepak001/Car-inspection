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
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        foreach (['brand', 'model_name', 'location', 'inspector', 'rc_status', 'insurance_type'] as $field) {
            $customField = $field.'_custom';
            if ($this->input($field) === '__other__' && filled($this->input($customField))) {
                $this->merge([$field => trim((string) $this->input($customField))]);
            }
        }

        if ($this->filled('chassis_number')) {
            $code = strtoupper(trim((string) $this->input('chassis_number')));
            $this->merge([
                'chassis_number' => $code,
                'vin' => $code,
            ]);
        } elseif ($this->filled('vin') && ! $this->filled('chassis_number')) {
            $this->merge([
                'vin' => strtoupper(trim((string) $this->input('vin'))),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'brand' => ['required', 'string', 'max:100', 'not_in:__other__'],
            'model_name' => ['required', 'string', 'max:100', 'not_in:__other__'],
            'location' => ['required', 'string', 'max:100', 'not_in:__other__'],
            'inspector' => ['required', 'string', 'max:255', 'not_in:__other__'],
            'inspected_on' => ['required', 'date'],
            'vehicle_number' => ['nullable', 'string', 'max:50'],
            'chassis_number' => [
                'sometimes',
                'nullable',
                'string',
                'size:17',
                'alpha_num',
                'unique:inspections,chassis_number',
            ],
            'vin' => ['nullable', 'string', 'max:50'],
            'engine_number' => ['nullable', 'string', 'max:50'],
            'vehicle_variant' => ['nullable', 'string', 'max:100'],
            'rc_status' => ['nullable', 'string', 'max:100', 'not_in:__other__'],
            'rc_front' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'rc_back' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'rc_valid_until' => ['nullable', 'date'],
            'insurance_type' => ['nullable', 'string', 'max:100', 'not_in:__other__'],
            'insurance_file' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'insurance_valid_until' => ['nullable', 'date'],
            'approx_expense' => ['nullable', 'string', 'max:50'],
            'market_value' => ['nullable', 'string', 'max:50'],
            'sale_price' => ['nullable', 'string', 'max:50'],
            'file_number' => ['nullable', 'string', 'max:50'],
            'rto_location' => ['nullable', 'string', 'max:100'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'remark' => ['nullable', 'string', 'max:2000'],
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
        $messages = [
            'brand.not_in' => 'Please select or enter a valid brand.',
            'model_name.not_in' => 'Please select or enter a valid model.',
            'location.not_in' => 'Please select or enter a valid location.',
            'inspector.not_in' => 'Please select or enter a valid inspector.',
            'rc_status.not_in' => 'Please select or enter a valid RC status.',
            'insurance_type.not_in' => 'Please select or enter a valid insurance type.',
            'chassis_number.size' => 'The chassis number must be exactly 17 characters.',
            'chassis_number.alpha_num' => 'The chassis number must contain only letters and numbers.',
            'chassis_number.unique' => 'This chassis number has already been inspected.',
        ];

        foreach (Inspection::checklistItems() as $key => $item) {
            $messages["items.{$key}.score.required"] = "Rate {$item['label']} out of 10.";
        }

        return $messages;
    }
}
