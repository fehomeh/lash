<?php

namespace Lash\Domain\Order;

interface OriginRequestCounterInterface
{
    /**
     * Increments number of requests from specific country. If there is no data - creates new counter with value "1".
     *
     * @param string $country
     */
    public function increment(string $country): void;

    /**
     * Counts amount of request for a given country.
     *
     * @param string $country
     *
     * @return int
     */
    public function countRequest(string $country): int;
}
