<?php

namespace Tests\Feature;

use App\Facades\SwProducts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SwProductsTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function getProvider()
    {
        return [
            "url" => 'https://sw-games.net/api/users/info',
            "apikey" => '26165dc7844c2cd1b9c8b0beA54e0A0c'
        ];
    }
    public function testGetBalance()
    {
        $placeOrderResponse = SwProducts::setProvider($this->getProvider())
            ->getUserBalance();

//                dd($placeOrderResponse);
        $this->assertUnifiedResponse($placeOrderResponse);
        $this->assertEquals($this->package['track_id'], $placeOrderResponse['track_id']);
    }

}
