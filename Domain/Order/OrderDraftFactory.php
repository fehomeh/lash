<?php

namespace Lash\Domain\Order;

use Lash\Domain\Order\Entity\OrderDraft;
use Ramsey\Uuid\Uuid;

class OrderDraftFactory
{
    /**
     * @param string $countryCode
     * @param \SplObjectStorage $products
     *
     * @return OrderDraft
     */
    public function create(string $countryCode, \SplObjectStorage $products): OrderDraft
    {
        return new OrderDraft(Uuid::uuid1(), $countryCode, $products);
    }
}
