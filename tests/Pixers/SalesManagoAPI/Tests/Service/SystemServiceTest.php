<?php

namespace Pixers\SalesManagoAPI\Tests\Service;

use Pixers\SalesManagoAPI\Service\SystemService;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class SystemServiceTest extends AbstractServiceTest
{
    /**
     * @var RuleService
     */
    protected static $systemService;

    /**
     * Setup system service.
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$systemService = new SystemService(self::$salesManagoClient);
    }

    public function testRegisterAccount()
    {
        if (self::$config['isPartner'] === false) {
            return;
        }

        $data = [
            'email' => self::$config['contactEmail'],
            'password' => 'secret_password'
        ];

        $response = self::$systemService->registerAccount($data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertIsBool($response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertIsArray($response->message);

        $this->assertObjectHasAttribute('clientId', $response);
        $this->assertIsString($response->clientId);
        $this->assertNotEmpty($response->clientId);

        $this->assertObjectHasAttribute('apiSecret', $response);
        $this->assertIsString($response->apiSecret);
        $this->assertNotEmpty($response->apiSecret);
    }

    public function testAuthorise()
    {
        $data = [
            'userName' => self::$config['clientEmail'],
            'password' => self::$config['clientPassword'],
            'clientId' => null,
            'apiKey' => null,
            'requestTime' => null,
            'sha' => null
        ];

        $response = self::$systemService->authorise($data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertIsBool($response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertIsArray($response->message);

        $this->assertObjectHasAttribute('clientId', $response);
        $this->assertIsString($response->clientId);
        $this->assertNotEmpty($response->clientId);

        $this->assertObjectHasAttribute('token', $response);
        $this->assertIsString($response->token);
        $this->assertNotEmpty($response->token);

        $this->assertObjectHasAttribute('validTo', $response);
        $this->assertIsFloat($response->validTo);
        $this->assertNotEmpty($response->validTo);
    }
}
