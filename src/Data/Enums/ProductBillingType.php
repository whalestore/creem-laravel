<?php

namespace Creem\Data\Enums;

enum ProductBillingType: string
{
    case Recurring = 'recurring';
    case Onetime = 'onetime';
}
