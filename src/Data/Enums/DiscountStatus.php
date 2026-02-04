<?php

namespace Creem\Data\Enums;

enum DiscountStatus: string
{
    case Active = 'active';
    case Draft = 'draft';
    case Expired = 'expired';
    case Scheduled = 'scheduled';
}
