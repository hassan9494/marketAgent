<?php

namespace App\ExternalServices\SmsActivate;

use App\ExternalServices\AbstractOperation;

class AbstractSmsActivateOperation extends AbstractOperation
{
    public function getHeader(): array
    {
        return [
            "Content-Type : application/json",
            "Accept : application/json",
        ];
    }

    public function getUrl()
    {
        $apikey = $this->provider["apikey"];
        return $this->getBaseUrl() . "?api_key={$apikey}" . "&action={$this->getOperationUrl()}";
    }

    public function getBody()
    {
        return $this->body ?? [];
    }

    public function getBaseUrl(): string
    {
        return $this->provider["url"];
    }

}
