<?php

namespace App\Http\Requests;

use App\Appraise;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class AppraiseRequest
 * @package App\Http\Requests
 */
class AppraiseRequest extends FormRequest
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
            'employee' => 'required',
            'peer'     => 'required',
        ];
    }
}
