<?php
declare(strict_types=1);

namespace App\Http\Requests\Account;

use App\Entities\Currency;
use App\Entities\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'max:255',
                'email',
                Rule::unique(User::class, 'email')->ignore($this->user()->getKey())
            ],
            'password' => ['nullable', Password::default()],
            'default_currency_id' => ['required', 'integer', Rule::exists(Currency::class, 'id')],
        ];
    }
}
