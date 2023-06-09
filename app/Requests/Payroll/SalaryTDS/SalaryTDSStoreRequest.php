<?php

namespace App\Requests\Payroll\SalaryTDS;

use App\Models\SalaryTDS;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SalaryTDSStoreRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return  [
            'marital_status' => ['required',Rule::in(SalaryTDS::MARITAL_STATUS)],
            'annual_salary_from' => ['required', 'array', 'min:1'],
            'annual_salary_from.*' => ['required', 'numeric'],
            'annual_salary_to' => ['required_with:annual_salary_from', 'array', 'min:1'],
            'annual_salary_to.*' => ['required_with:annual_salary_from.*','nullable','numeric','gt:annual_salary_from.*' ],
            'tds_in_percent' => ['required_with:annual_salary_from', 'array', 'min:1'],
            'tds_in_percent.*' => ['required_with:annual_salary_from.*','nullable', 'numeric' ],
        ];

    }

    public function messages(): array
    {
        return [
            'annual_salary_from.*.required'  => 'Annual Salary From Is Required',
            'annual_salary_to.*.required_with'  => 'Annual Salary To Is With Annual Salary From',
            'annual_salary_to.*.gt'  => 'Annual Salary To Must Be Greater Than Annual Salary From',
            'tds_in_percent.*.required_with'  => 'Salary TDS Is Required With Annual Salary From',
        ];
    }
}
