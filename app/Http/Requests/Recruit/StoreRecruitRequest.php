<?php

namespace App\Http\Requests\Recruit;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecruitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('recruit-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'status' => 'required',
            'user_assigned_id' => 'required',
            'user_created_id' => '',
            'athlete_id' => 'required',
            'contact_date' => 'required'
        ];
    }
}
