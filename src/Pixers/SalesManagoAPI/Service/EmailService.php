<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class EmailService extends AbstractService
{
    /**
     * Sending SalesManago e-mail.
     *
     * @param  array $data E-mail data
     */
    public function create(array $data): object
    {
        return $this->client->doPost('email/send', $data);
    }
}
