<?php

namespace Creem\Data\Enums;

enum EnvironmentMode: string
{
    case Test = 'test';
    case Prod = 'prod';
    case Sandbox = 'sandbox';
}
