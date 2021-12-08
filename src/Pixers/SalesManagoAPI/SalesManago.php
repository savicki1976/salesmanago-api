<?php

namespace Pixers\SalesManagoAPI;

use Pixers\SalesManagoAPI\Client;
use Pixers\SalesManagoAPI\Service;
use Pixers\SalesManagoAPI\Service\AbstractService;
use Pixers\SalesManagoAPI\Service\ContactService;
use Pixers\SalesManagoAPI\Service\CouponService;
use Pixers\SalesManagoAPI\Service\EmailService;
use Pixers\SalesManagoAPI\Service\EventService;
use Pixers\SalesManagoAPI\Service\MailingListService;
use Pixers\SalesManagoAPI\Service\PhoneListService;
use Pixers\SalesManagoAPI\Service\RuleService;
use Pixers\SalesManagoAPI\Service\SystemService;
use Pixers\SalesManagoAPI\Service\TagService;
use Pixers\SalesManagoAPI\Service\TaskService;

/**
 * SalesManago Services Locator.
 *
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class SalesManago
{
    protected Client $client;

    /**
     * @var AbstractService[]
     */
    protected array $services;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->services = [];
    }

    public function getContactService(): ContactService
    {
        return $this->getService(ContactService::class);
    }

    public function getCouponService(): CouponService
    {
        return $this->getService(CouponService::class);
    }

    public function getEmailService(): EmailService
    {
        return $this->getService(Service\EmailService::class);
    }

    public function getEventService(): EventService
    {
        return $this->getService(EventService::class);
    }

    public function getMailingListService(): MailingListService
    {
        return $this->getService(MailingListService::class);
    }

    public function getPhoneListService(): PhoneListService
    {
        return $this->getService(PhoneListService::class);
    }

    public function getRuleService(): RuleService
    {
        return $this->getService(RuleService::class);
    }

    public function getSystemService(): SystemService
    {
        return $this->getService(SystemService::class);
    }

    public function getTagService(): TagService
    {
        return $this->getService(TagService::class);
    }

    public function getTaskService(): TaskService
    {
        return $this->getService(TaskService::class);
    }

    /**
     * @template T of AbstractService
     * @param  class-string<T> $className
     * @return T
     */
    protected function getService(string $className): AbstractService
    {
        if (!isset($this->services[$className])) {
            $this->services[$className] = new $className($this->client);
        }

        if (! $this->services[$className] instanceof $className) {
            throw new \UnexpectedValueException(get_debug_type($this->services[$className]));
        }

        return $this->services[$className];
    }
}
