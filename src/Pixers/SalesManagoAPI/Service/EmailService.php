<?php

namespace Pixers\SalesManagoAPI\Service;

use GuzzleHttp\RequestOptions;

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
     * Sending SalesManago e-mail.
     *
     * @param  array{
     *     user: string,
     *     emailId: string,
     *     date: positive-int,
     *     html: ?string,
     *     campaign: ?string,
     *     subject:?string,
     *     contacts: array{
     *          addresseeType: string,value: string, properties: list<array{
     *              name:string,value:string
     *          }>
     *     }
     * } $data E-mail data
     */
    public function sendEmail(array $data): object
    {
        return $this->client->doPost('email/sendEmail', $data);
    }

    /**
     * Sending SalesManago e-mail.
     *
     * @param array{
     *     user: string,
     *     emailId: string,
     *     date: positive-int,
     *     html: ?string,
     *     campaign: ?string,
     *     subject:?string,
     *     contacts: array{
     *          addresseeType: string,email: string, properties: list<array{
     *              name:string,value:string
     *          }>
     *     }|array{
     *          addresseeType: string,contactId: string, properties: list<array{
     *              name:string,value:string
     *          }>
     *     }|array{
     *          addresseeType: string,tag: string, properties: list<array{
     *              name:string,value:string
     *          }>
     *     }
     * } $data E-mail data
     * @param resource $attachment
     */
    public function sendWithAttachment(array $data, $attachment, string $filename): object
    {
        return $this->client->doPost('email/sendWithAttachment', $data, [
            RequestOptions::MULTIPART => [
                [
                    'name' => 'attachment',
                    'contents' => $attachment,
                    'filename' => $filename,
                ]
            ],
        ]);
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
