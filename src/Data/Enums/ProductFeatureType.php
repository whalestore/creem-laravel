<?php

namespace Creem\Data\Enums;

enum ProductFeatureType: string
{
    case Custom = 'custom';
    case File = 'file';
    case LicenseKey = 'licenseKey';
}
