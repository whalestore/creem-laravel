<?php

namespace Creem\Data\Enums;

enum TransactionType: string
{
    case Payment = 'payment';
    case Invoice = 'invoice';
}
