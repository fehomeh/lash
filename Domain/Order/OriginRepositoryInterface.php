<?php

namespace Lash\Domain\Order;

interface OriginRepositoryInterface
{
    /**
     * Returns country ISO 3166 code by given IP address.
     *
     * @param string $ipAddress Format: xxx.xxx.xxx.xxx
     *
     * @return string
     */
    public function getCountryCode(string $ipAddress): string;
}