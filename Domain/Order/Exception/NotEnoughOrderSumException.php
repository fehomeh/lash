<?php

namespace Lash\Domain\Order\Exception;

use App\Http\HttpCodesInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Thrown when total price of products is not enough to create order.
 */
class NotEnoughOrderSumException extends \DomainException implements HttpExceptionInterface
{
    /**
     * @inheritdoc
     */
    public function getStatusCode(): int
    {
        return HttpCodesInterface::PRECONDITION_FAILED;
    }

    /**
     * @inheritdoc
     */
    public function getHeaders(): array
    {
        return [];
    }
}
