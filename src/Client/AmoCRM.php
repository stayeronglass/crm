<?php
declare(strict_types=1);

namespace App\Client;
use GuzzleHttp\Client;

class AmoCRM
{
    private readonly Client $client;
    public function __construct(string $secret)
    {
        $this->client = new Client();
    }


}
