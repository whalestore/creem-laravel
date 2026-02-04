<?php

namespace Creem\Data\Enums;

enum SubscriptionStatus: string
{
    case Active = 'active';
    case Canceled = 'canceled';
    case Unpaid = 'unpaid';
    case Paused = 'paused';
    case Trialing = 'trialing';
    case ScheduledCancel = 'scheduled_cancel';
}
