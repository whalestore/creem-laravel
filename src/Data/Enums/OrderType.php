<?php

namespace Creem\Data\Enums;

enum OrderType: string
{
    case Recurring = 'recurring';
    case Onetime = 'onetime';
}
