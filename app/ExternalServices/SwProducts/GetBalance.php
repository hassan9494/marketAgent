<?php

namespace App\ExternalServices\SwProducts;

use App\ExternalServices\ExternalProviderResponse;

class GetBalance extends AbstractSwProductsOperation
{
    protected string $operationUrl = 'getBalance';
    protected string $method = 'get';

    public function returnDeliveryPortalResponse($jsonDecode): array
    {
        $response = new ExternalProviderResponse();
        $response->setIsSuccess(true);
        $response->setPayload($jsonDecode);
        $response->setTrackId($this->getTrackId());
        return $response->return();
    }


}
