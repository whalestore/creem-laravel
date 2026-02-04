<?php

namespace Creem\Data\Enums;

enum SubscriptionCollectionMethod: string
{
    case ChargeAutomatically = 'charge_automatically';
    case SendInvoice = 'send_invoice';
}
