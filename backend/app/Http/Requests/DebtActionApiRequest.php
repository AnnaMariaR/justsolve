<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form request for applying an action to a debt.
 */
class DebtActionApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'action' => 'required|string|in:SEND_REMINDER,OFFER_PAYMENT_PLAN,ESCALATE_LEGAL',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'action.required' => 'An action is required',
            'action.in' => 'The action must be one of: SEND_REMINDER, OFFER_PAYMENT_PLAN, ESCALATE_LEGAL',
        ];
    }
}
