<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SendTaskCancelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'bid_id' => 'required|integer',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->messages()->all();
        throw new HttpResponseException(response()->json([
            'message' => $errors[0],
            'status' => false,
            'data' => null,
            'code' => 422,
        ], 422));
    }
}
