<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class MailingListService extends AbstractService
{
    /**
     * Add a contact to mailing list.
     *
     * @param  string $email Contact e-mail address
     */
    public function add($email): object
    {
        return $this->client->doPost('contact/optin', [
            'email' => $email,
        ]);
    }

    /**
     * Remove a contact to mailing list.
     *
     * @param  string $email Contact e-mail address
     */
    public function remove($email): object
    {
        return $this->client->doPost('contact/optout', [
            'email' => $email,
        ]);
    }
}
