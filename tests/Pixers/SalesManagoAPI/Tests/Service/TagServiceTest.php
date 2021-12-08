<?php

namespace Pixers\SalesManagoAPI\Tests\Service;

use Pixers\SalesManagoAPI\Service\TagService;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class TagServiceTest extends AbstractServiceTest
{
    /**
     * @var TagService
     */
    protected static $tagService;

    /**
     * Setup tag service.
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        self::$tagService = new TagService(self::$salesManagoClient);

        self::createContact();
    }

    public function testGetAll(): void
    {
        $data = [
            'showSystemTags' => true
        ];

        $response = self::$tagService->getAll(self::$config['owner'], $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertIsBool($response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertIsArray($response->message);

        $this->assertObjectHasAttribute('tags', $response);
        $this->assertIsArray($response->tags);
    }

    public function testModify(): void
    {
        $dataTags = [
            'tags' => ['TAG_4', 'TAG_5', 'TAG_6'],
            'removeTags' => ['TAG_1', 'TAG_2']
        ];

        $response = self::$tagService->modify(self::$config['owner'], self::$config['contactEmail'], $dataTags);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertIsBool($response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertIsArray($response->message);

        $this->assertObjectHasAttribute('contactId', $response);
        $this->assertIsString($response->contactId);
        $this->assertNotEmpty($response->contactId);

        $contactId = $response->contactId;
        $data = [
            'contactId' => [
                $response->contactId
            ]
        ];

        $response = self::$contactService->listByIds(self::$config['owner'], $data);

        $this->assertInstanceOf(\stdClass::class, $response);

        $this->assertObjectHasAttribute('success', $response);
        $this->assertIsBool($response->success);
        $this->assertTrue($response->success);

        $this->assertObjectHasAttribute('message', $response);
        $this->assertIsArray($response->message);

        $this->assertObjectHasAttribute('contacts', $response);
        $this->assertIsArray($response->contacts);
        $this->assertNotEmpty($response->contacts);
        $this->assertCount(1, $response->contacts);

        $contactData = $response->contacts[0];

        $this->assertInstanceOf(\stdClass::class, $contactData);
        $this->assertEquals($contactId, $contactData->id);
        $this->assertObjectHasAttribute('contactTags', $contactData);
        $this->assertIsArray($contactData->contactTags);
        $this->assertNotEmpty($contactData->contactTags);

        $tagNames = [];
        $contactTags = $contactData->contactTags;
        foreach ($contactTags as $contactTag) {
            $this->assertInstanceOf(\stdClass::class, $contactTag);

            $this->assertObjectHasAttribute('tag', $contactTag);
            $this->assertIsString($contactTag->tag);

            $this->assertObjectHasAttribute('tagName', $contactTag);
            $this->assertIsString($contactTag->tagName);

            $this->assertObjectHasAttribute('score', $contactTag);
            $this->assertIsInt($contactTag->score);

            $this->assertObjectHasAttribute('createdOn', $contactTag);
            $this->assertIsFloat($contactTag->createdOn);

            $this->assertObjectHasAttribute('tagWithScore', $contactTag);
            $this->assertIsString($contactTag->tagWithScore);

            $tagNames[$contactTag->tag] = $contactTag->tag;
        }

        foreach ($dataTags['tags'] as $tag) {
            $this->assertArrayHasKey($tag, $tagNames);
        }

        foreach ($dataTags['removeTags'] as $tag) {
            $this->assertArrayNotHasKey($tag, $tagNames);
        }
    }

    /**
     * Removing contact.
     */
    public static function tearDownAfterClass(): void
    {
        self::removeContact();
    }
}
