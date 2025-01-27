<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    /**
     * @return array<string, array<mixed>|\Illuminate\Contracts\Validation\ValidationRule|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'comment' => ['required', 'string', 'min:3', 'max:255'],
            'date' => ['nullable', 'string', 'date', 'date_format:Y-m-d', 'after_or_equal:today'],
            'files' => ['nullable', 'array'],
            'files.*' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:10240'],
        ];
    }
}
