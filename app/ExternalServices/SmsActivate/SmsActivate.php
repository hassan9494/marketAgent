<?php

namespace App\ExternalServices\SmsActivate;

use App\ExternalServices\ProviderInterface;

class SmsActivate implements ProviderInterface
{
    protected array $provider;

    public function getServices(): array
    {
        // TODO: Implement getServices() method.
    }

    public function getUserBalance(): array
    {
        return GetBalance::setProvider($this->provider)->send();
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
        $this->provider=$provider;
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
                    ['label' => 'production', 'value' => 'https://api.sms-activate.org/stubs/handler_api.php']
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
