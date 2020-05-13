<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUpdateRequest extends FormRequest
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
            'file' => ['image', 'max:5120'],
            'comment' => ['max:255'],
            'delete_date' => $this->request->get('delete_date') !== null
                ? ['after_or_equal:now', 'date_format:m/d/Y']
                : [],
        ];
    }
}
