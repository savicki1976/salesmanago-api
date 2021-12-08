<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class SystemService extends AbstractService
{
    /**
     * Register system account (only for SalesManago partners).
     *
     * @param array $data Account data
     */
    public function registerAccount(array $data): object
    {
        return $this->client->doPost('system/registeraccount', $data);
    }

    /**
     * Temporary authorise.
     *
     * @param  array $data
     */
    public function authorise(array $data): object
    {
        return $this->client->doPost('system/authorise', $data);
    }
}
