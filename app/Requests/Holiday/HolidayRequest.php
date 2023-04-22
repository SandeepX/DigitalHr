<?php

namespace App\Requests\Holiday;


use App\Helpers\AppHelper;
use Illuminate\Foundation\Http\FormRequest;

class HolidayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        if (AppHelper::ifDateInBsEnabled()) {
            $this->merge([
                'event_date' => AppHelper::dateInYmdFormatNepToEng($this->event_date),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'event' => 'required|string',
            'note' => 'nullable|string|max:1000',
        ];
        if ($this->isMethod('put')) {
            $rules['event_date'] = 'required|date';
        } else {
            $rules['event_date'] = 'required|date|after:yesterday';
        }
        return $rules;
    }

}














