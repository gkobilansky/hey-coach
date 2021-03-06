<?php

namespace App\Http\Requests\Athlete;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAthleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('athlete-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'company_name' => 'required',
            'email' => 'required',
            'address' => '',
            'zipcode' => 'max:6',
            'city' => '',
            'primary_number' => 'max:10',
            'secondary_number' => 'max:10',
            'company_type' => '',
            'user_id' => 'required'
        ];
    }
}
