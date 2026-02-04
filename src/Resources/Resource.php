<?php

namespace Creem\Resources;

use Creem\Http\HttpClient;

abstract class Resource
{
    protected HttpClient $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }
}
