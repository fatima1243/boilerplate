<?php

namespace App\Http\Requests\Task;

use App\Models\Card;
use App\Utilities\Constants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateTaskRequest extends FormRequest
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
            'title' => 'required',
            'service_type' => 'required|string|max:255',
            'service_date' => 'required|date',
            'service_duration' => 'required|string|max:255',
            'additional_details' => 'nullable|string',
            'pickup_location' => 'required|string',
            'dropoff_location' => 'required|string',
            'distance' => 'required'
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
