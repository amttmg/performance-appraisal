<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeCsvRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'importedFile' => 'required',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validHeaders = [
            "name",
            "username",
            "email",
            "technology_id",
            "role_id",
        ];
        $csvHeader    = getCsvHeader($this->file('importedFile'));
        $invalidHeaders = array_diff($validHeaders, $csvHeader);

        $validator->after(function ($validator) use ($invalidHeaders, $validHeaders) {
            if (count($invalidHeaders)) {
                $validator->errors()->add('invalid_headers', array_map(function ($data) {
                    return title_case(str_replace('_', ' ', $data));
                }, $invalidHeaders));
                $validator->errors()->add('valid_headers', array_map(function ($data) {
                    return title_case(str_replace('_', ' ', $data));
                }, $validHeaders));
            }
        });
    }
}
