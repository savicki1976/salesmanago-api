<?php

namespace Pixers\SalesManagoAPI\Tests\Service;

use Pixers\SalesManagoAPI\Service\EmailService;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class EmailServiceTest extends AbstractServiceTest
{
    /**
     * @var EmailService
     */
    protected static $emailService;

    /**
     * Setup email service.
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$emailService = new EmailService(self::$salesManagoClient);
    }

    public function testCreate(): void
    {
        $data = [
            'user' => self::$config['owner'],
            'immediate' => true,
            'emailId' => self::$config['emailId'],
            'contacts' => [
                [
                    'email' => self::$config['contactEmail'],
                ]
            ],
            'date' => date('c', time()),
        ];

        $response = self::$emailService->create($data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertIsBool($response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertIsArray($response->message);

        $this->assertObjectHasAttribute('conversationId', $response);
        $this->assertIsString($response->conversationId);
        $this->assertNotEmpty($response->conversationId);
    }
}
