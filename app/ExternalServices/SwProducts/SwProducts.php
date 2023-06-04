<?php

namespace App\ExternalServices\SwProducts;

use App\ExternalServices\ProviderInterface;
use App\ExternalServices\SwProducts\GetBalance;

class SwProducts implements ProviderInterface
{
    protected array $provider;


    public function getServices(): array
    {
        // TODO: Implement getServices() method.
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserBalance(): array
    {
        return GetBalance::setProvider($this->provider)->send();
    }

    public function getUserInformation(): array
    {
        // TODO: Implement getUserBalance() method.
    }

    public function placeOrder(): array
    {
        // TODO: Implement placeOrder() method.
    }

    public function getOrderStatus(string $orderId, string $reference): array
    {
        // TODO: Implement getOrderStatus() method.
    }


    public function setProvider($provider): ProviderInterface
    {
        $this->provider = $provider;
        return $this;
    }

    public function getProviderSettings(): array
    {
        return [
            [
                'name' => 'url',
                'isRequired' => 'true',
                'type' => 'select',
                'options' => [
                    ['label' => 'production', 'value' => 'https://sw-games.net/api/']
                ]
            ],
            [
                'name' => 'apikey',
                'isRequired' => 'true',
                'type' => 'text',
            ],
        ];
    }
}
