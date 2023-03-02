<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookingRequest extends FormRequest
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
            'from_id' => 'required|integer',
            'back_id' => 'required|integer',
            'tourists' => 'required|array',
            'tourists.*.first_name' => 'required|string',
            'tourists.*.last_name' => 'required|string',
            'tourists.*.birth_date' => 'required|date',
            'tourists.*.document_number' => 'required|integer|digits_between:10,10'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'error' => [
                'code' => 422,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ]
        ]));
    }
}
