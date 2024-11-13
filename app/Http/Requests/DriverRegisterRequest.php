<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;

class DriverRegisterRequest extends FormRequest
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
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'email' => 'required|email',
            'contact_no' => 'required|string',
            'password' => 'required|string|min:6', // Adjust the minimum length as needed
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            // 'cnic_front' => 'required', // Adjust the file types and max size as needed
            // 'cnic_back' => 'required',
            // 'driving_license' => 'required',
            // 'vehicle_insurance' => 'required',
            'vehicleType' => 'required|string',
            'vehicleMakeModel' => 'required|string',
            'yearOfProduction' => 'required|integer|min:1900|max:' . date('Y'), // Adjust the min year as needed
            'vehicleColor' => 'required|string',
            'vehiclePlates' => 'required|string',
            'drivingExperience' => 'required|string',
        ];
    }

}
