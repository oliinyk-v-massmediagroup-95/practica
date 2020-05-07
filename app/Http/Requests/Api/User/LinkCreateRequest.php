<?php

namespace App\Http\Requests\Api\User;

use App\Models\Link;
use Illuminate\Foundation\Http\FormRequest;

class LinkCreateRequest extends FormRequest
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
            'file_id' => ['required'],
            'only_once' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value != Link::MULTI_TIME_LINK && $value != Link::ONE_TIME_LINK) {
                        $fail($attribute. ' is invalid.');
                    }
                },
            ]
        ];
    }
}
