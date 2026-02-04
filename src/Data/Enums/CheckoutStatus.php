<?php

namespace Creem\Data\Enums;

enum CheckoutStatus: string
{
    case Pending = 'pending';
    case Processing = 'processing';
    case Completed = 'completed';
    case Expired = 'expired';
}
