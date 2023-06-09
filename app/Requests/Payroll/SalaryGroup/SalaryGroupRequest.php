<?php

namespace App\Requests\Payroll\SalaryGroup;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalaryGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'salary_component_id' => ['required', 'array', 'min:1'],
            'salary_component_id.*' => [
                'required',
                Rule::exists('salary_components', 'id')->where('status', true)
            ],
            'salary_group_employee.*' => [
                'required',
                Rule::exists('users', 'id')
                ->where('is_active', true)
                ->where('status','verified')
            ],
        ];
    }

}
