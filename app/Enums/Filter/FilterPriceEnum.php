<?php
declare(strict_types=1);

namespace App\Enums\Filter;

use App\Helpers\EnumHelper;

enum FilterPriceEnum: string
{
    use EnumHelper;

    case BASE = 'base';
    case CONVERTED = 'converted';
}
