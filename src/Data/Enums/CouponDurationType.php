<?php

namespace Creem\Data\Enums;

enum CouponDurationType: string
{
    case Forever = 'forever';
    case Once = 'once';
    case Repeating = 'repeating';
}
