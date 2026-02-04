<?php

namespace Creem\Data\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
}
