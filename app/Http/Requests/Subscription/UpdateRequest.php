<?php
declare(strict_types=1);

namespace App\Http\Requests\Subscription;

use App\Entities\Currency;
use App\Enums\Subscription\SubscriptionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:512'],
            'price' => ['required', 'numeric', 'nullable', 'min:0'],
            'currency_id' => ['required', Rule::exists(Currency::class, 'id')],
            'type' => [
                'required', 'string', Rule::in([
                    SubscriptionTypeEnum::DAILY->value,
                    SubscriptionTypeEnum::WEEKLY->value,
                    SubscriptionTypeEnum::MONTHLY->value,
                    SubscriptionTypeEnum::YEARLY->value,
                ])
            ],
        ];
    }
}
