<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class CouponService extends AbstractService
{
    /**
     * Adding a new coupon to contact.
     *
     * @param  array<string, mixed>  $data  Client data
     */
    public function create(string $owner, string $email, array $data): object
    {
        $data = self::mergeData($data, [
            'owner' => $owner,
            'email' => $email,
        ]);

        return $this->client->doPost('contact/addContactCoupon', $data);
    }
}
