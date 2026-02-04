<?php

namespace Creem\Data\Enums;

enum TransactionStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Refunded = 'refunded';
    case PartialRefund = 'partialRefund';
    case ChargedBack = 'chargedBack';
    case Uncollectible = 'uncollectible';
    case Declined = 'declined';
    case Void = 'void';
}
