<?php

namespace Pixers\SalesManagoAPI\Tests\Service;

use Pixers\SalesManagoAPI\Service\PhoneListService;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class PhoneListServiceTest extends AbstractServiceTest
{
    /**
     * @var PhoneListService
     */
    protected static $phoneListService;

    /**
     * Setup phone list service.
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$phoneListService = new PhoneListService(self::$salesManagoClient);

        self::createContact();
    }

    public function testAdd(): string
    {
        $response = self::$phoneListService->add(self::$config['contactEmail']);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertIsBool($response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertIsArray($response->message);

        $this->assertObjectHasAttribute('contactId', $response);
        $this->assertIsString($response->contactId);
        $this->assertNotEmpty($response->contactId);

        return $response->contactId;
    }

    /**
     * @depends testAdd
     */
    public function testRemove(string $contactId): void
    {
        $response = self::$phoneListService->remove(self::$config['contactEmail']);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertIsBool($response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertIsArray($response->message);

        $this->assertObjectHasAttribute('contactId', $response);
        $this->assertIsString($response->contactId);
        $this->assertEquals($contactId, $response->contactId);
        $this->assertNotEmpty($response->contactId);
    }

    public static function tearDownAfterClass(): void
    {
        self::removeContact();
    }
}
