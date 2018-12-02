<?php

namespace Lash\Domain\Order;

use Lash\Domain\Order\Entity\OrderDraft;

interface OrderDraftRepositoryInterface
{
    /**
     * Saves order to DB.
     *
     * @param OrderDraft $orderDraft
     */
    public function save(OrderDraft $orderDraft): void;
}
