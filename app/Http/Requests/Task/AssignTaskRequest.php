<?php

namespace App\Http\Requests\Task;

use App\Models\Card;
use App\Models\User;
use App\Models\UserMeta;
use App\Utilities\Constants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class AssignTaskRequest extends FormRequest
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
        $this->request->add(['user_id' => auth()->id()]);

        return [
            'task_id' => 'required|exists:tasks,id',
            'pro_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if ($user && $user->role !== Constants::USER_ROLE['pro']) {
                        $fail('The pro user is invalid.');
                    }
                    if ($user && $user->account_status != 1) {
                        $fail('You can not send task to this user.');
                    }
                },
            ],
            'user_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $user = auth()->user();
                    // dd($user->role !== Constants::USER_ROLE['user'], $user->role , Constants::USER_ROLE['user']);
                    if ($user->role !== Constants::USER_ROLE['user']) {
                        $fail('You are not user.');
                    }
                    $user_meta = UserMeta::where('user_id', $user->id)->first();
                    if (!$user_meta->connected_stripe_account_id) {
                        $fail('Please connect stripe account first.');
                    }
                    $card_exists = Card::where('user_id', $user->id)->where('is_default', 1)->exists();
                    if (!$card_exists) {
                        $fail('Please connect card first for payment.');
                    }
                },
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->messages()->all();
        throw new HttpResponseException(response()->json([
            'message' => $errors[0],
            'status' => false,
            'data' => null,
            'code' => Response::HTTP_OK,
        ], Response::HTTP_OK));
    }
}
