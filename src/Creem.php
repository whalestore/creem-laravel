<?php

namespace Creem;

use Creem\Http\HttpClient;
use Creem\Resources\Products;
use Creem\Resources\Customers;
use Creem\Resources\Subscriptions;
use Creem\Resources\Checkouts;
use Creem\Resources\Licenses;
use Creem\Resources\Discounts;
use Creem\Resources\Transactions;

class Creem
{
    protected HttpClient $client;

    public Products $products;
    public Customers $customers;
    public Subscriptions $subscriptions;
    public Checkouts $checkouts;
    public Licenses $licenses;
    public Discounts $discounts;
    public Transactions $transactions;

    public function __construct(array $config = [])
    {
        $this->client = new HttpClient($config);

        $this->products = new Products($this->client);
        $this->customers = new Customers($this->client);
        $this->subscriptions = new Subscriptions($this->client);
        $this->checkouts = new Checkouts($this->client);
        $this->licenses = new Licenses($this->client);
        $this->discounts = new Discounts($this->client);
        $this->transactions = new Transactions($this->client);
    }

    /**
     * Get the HTTP client instance.
     */
    public function getClient(): HttpClient
    {
        return $this->client;
    }
}
