<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id');

        if (!$userId) {
            throw new \Exception('User ID is null. Periksa route dan form action!');
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => ['nullable', 'min:6', 'same:confirm-password'],
            'confirm-password' => ['nullable', 'min:6'],
            'role' => ['required', 'string'],
        ];
    }
}
