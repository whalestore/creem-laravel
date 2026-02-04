<?php

namespace Creem\Data\Enums;

enum ProductBillingPeriod: string
{
    case EveryMonth = 'every-month';
    case EveryThreeMonths = 'every-three-months';
    case EverySixMonths = 'every-six-months';
    case EveryYear = 'every-year';
    case Once = 'once';
}
