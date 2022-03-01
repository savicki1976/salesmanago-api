<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
final class EmailService extends AbstractService
{
    /**
     * Sending SalesManago e-mail.
     *
     * @param  array<string, mixed> $data E-mail data
     */
    public function create(array $data): object
    {
        return $this->client->doPost('email/send', $data);
    }

    /**
     * @param  array<string, mixed> $data
     */
    public function sendConfirmation(string $owner, string $email, array $data): object
    {
        $data['owner'] = $owner;
        $data['email'] = $email;

        return $this->client->doPost('email/sendConfirmation', $data);
    }
}
