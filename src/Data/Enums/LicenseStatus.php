<?php

namespace Creem\Data\Enums;

enum LicenseStatus: string
{
    case Inactive = 'inactive';
    case Active = 'active';
    case Expired = 'expired';
    case Disabled = 'disabled';
}
