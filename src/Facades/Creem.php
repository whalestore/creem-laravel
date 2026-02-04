<?php

namespace Creem\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Creem\Resources\Products products()
 * @method static \Creem\Resources\Customers customers()
 * @method static \Creem\Resources\Subscriptions subscriptions()
 * @method static \Creem\Resources\Checkouts checkouts()
 * @method static \Creem\Resources\Licenses licenses()
 * @method static \Creem\Resources\Discounts discounts()
 * @method static \Creem\Resources\Transactions transactions()
 *
 * @see \Creem\Creem
 */
class Creem extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Creem\Creem::class;
    }
}
