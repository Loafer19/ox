<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
{
    /**
     * @return array<string, array<mixed>|\Illuminate\Contracts\Validation\ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'status_id' => ['required', 'integer', 'exists:statuses,id'],
            'comment' => ['required', 'string', 'min:3', 'max:255'],
            'date' => ['nullable', 'string', 'date', 'date_format:Y-m-d', 'after_or_equal:today'],
        ];
    }
}
