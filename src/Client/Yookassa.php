<?php
declare(strict_types=1);

namespace App\Client;

use YooKassa\Client;
use YookassaException;

class Yookassa
{
    private readonly Client $client;

    public function __construct(string $secret)
    {
        $client = new Client();
        $client->setAuth('shopId', $secret);

        $this->client = $client;
    }

    public function getPaymentLink($value, string $description, string $returnUrl): ?\YooKassa\Request\Payments\CreatePaymentResponse
    {
        if (mb_strlen($description, 'UTF-8') > 128) {
            $len = mb_strlen($description, 'UTF-8');
            throw new YookassaException("Слишком длинное описание {$len} символов, должно быть до 128 символов!");
        }

        $payment = $this->client->createPayment([
            'amount'       => [
                'value'    => (string)$value,
                'currency' => 'RUB',
            ],
            'capture'      => true,
            "confirmation" => [
                'type'       => 'redirect',
                'return_url' => $returnUrl,
            ],
            'description'  => $description,
        ]);

        return $payment;
    }
}
