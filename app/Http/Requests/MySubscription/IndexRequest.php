<?php
declare(strict_types=1);

namespace App\Http\Requests\MySubscription;

use App\Enums\Filter\FilterPriceEnum;
use App\Enums\Subscription\SubscriptionTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['string', Rule::in(SubscriptionTypeEnum::values())],
            'price_min' => ['integer', 'min:0', 'lte:price_max'],
            'price_max' => ['integer', 'min:0', 'gte:price_min'],
            'price' => ['string', Rule::in(FilterPriceEnum::values())],
            'month' => ['nullable', 'string', 'date_format:Y-m'],
        ];
    }
}
