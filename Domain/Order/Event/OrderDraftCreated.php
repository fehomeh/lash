<?php

namespace Lash\Domain\Order\Event;

use Lash\Domain\Order\Entity\OrderDraft;

class OrderDraftCreated
{
    /**
     * @var OrderDraft
     */
    private $order;

    /**
     * OrderDraftCreated constructor.
     * @param OrderDraft $order
     */
    public function __construct(OrderDraft $order)
    {
        $this->order = $order;
    }

    /**
     * @return OrderDraft
     */
    public function getOrder(): OrderDraft
    {
        return $this->order;
    }
}
