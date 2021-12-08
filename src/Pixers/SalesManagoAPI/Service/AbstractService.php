<?php

namespace Pixers\SalesManagoAPI\Service;

use Pixers\SalesManagoAPI\Client;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
abstract class AbstractService
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Replaces elements from passed arrays into the first array recursively.
     *
     * @param  array<string, mixed> $base         The array in which elements are replaced
     * @param  array<string, mixed> $replacements The array from which elements will be extracted
     * @return array<string, mixed>
     */
    protected static function mergeData(array $base, array $replacements): array
    {
        return array_replace_recursive($base, $replacements);
    }
}
