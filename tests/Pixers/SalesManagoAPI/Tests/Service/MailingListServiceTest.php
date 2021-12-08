<?php

namespace Pixers\SalesManagoAPI\Tests\Service;

use Pixers\SalesManagoAPI\Service\MailingListService;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class MailingListServiceTest extends AbstractServiceTest
{
    /**
     * @var MailingListService
     */
    protected static $mailingListService;

    /**
     * Setup mailing list service.
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$mailingListService = new MailingListService(self::$salesManagoClient);

        self::createContact();
    }

    public function testAdd(): string
    {
        $response = self::$mailingListService->add(self::$config['contactEmail']);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertIsBool($response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertIsArray($response->message);

        $this->assertObjectHasAttribute('contactId', $response);
        $this->assertIsString('string', $response->contactId);
        $this->assertNotEmpty($response->contactId);

        return $response->contactId;
    }

    /**
     * @depends testAdd
     */
    public function testRemove(string $contactId): void
    {
        $response = self::$mailingListService->remove(self::$config['contactEmail']);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertIsBool($response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertIsArray($response->message);

        $this->assertObjectHasAttribute('contactId', $response);
        $this->assertIsString('string', $response->contactId);
        $this->assertEquals($contactId, $response->contactId);
        $this->assertNotEmpty($response->contactId);
    }

    public static function tearDownAfterClass(): void
    {
        self::removeContact();
    }
}
