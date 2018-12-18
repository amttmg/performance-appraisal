<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectCsvRequest extends FormRequest
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
        $validHeaders   = [
            "project_code",
            "planned_vs_spent_hours",
            "planned_vs_spent_beta_release",
            "project_quality",
            "project_complexity",
            "bug_vs_planned",
            "code_quality",
            "total_score",
            "is_completed",
            "department",
        ];
        $csvHeader      = getCsvHeader($this->file('importedFile'));
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
