<?php

namespace App\EventListener;

use Lash\Domain\Order\Event\OrderDraftCreated;
use Lash\Domain\Order\OriginRequestCounterInterface;

class IncreaseOriginOrderNumber
{
    /**
     * @var OriginRequestCounterInterface
     */
    private $requestCounter;

    /**
     * IncreaseOriginOrderNumber constructor.
     * @param OriginRequestCounterInterface $requestCounter
     */
    public function __construct(OriginRequestCounterInterface $requestCounter)
    {
        $this->requestCounter = $requestCounter;
    }

    /**
     * Increases number of requests from specific country.
     * @param OrderDraftCreated $event
     */
    public function handle(OrderDraftCreated $event): void
    {
        $this->requestCounter->increment($event->getOrder()->getCountryCode());
    }
}
