<?php

use PHPUnit\Framework\TestCase;
use Pixers\SalesManagoAPI\Client;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function shouldPassedWhileCreatingClientWithData(): void
    {
        $clientId = 'test';
        $endPoint = 'test';
        $apiSecret = 'test'; 
        $apiKey = 'test';

        $this->expectNotToPerformAssertions();

        new Client(new GuzzleHttp\Client(), $clientId, $endPoint, $apiSecret, $apiKey);
    }
}
