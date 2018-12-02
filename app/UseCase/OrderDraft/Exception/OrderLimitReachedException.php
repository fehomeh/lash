<?php

namespace App\UseCase\OrderDraft\Exception;

use App\Http\HttpCodesInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Thrown when amount of requests for creating an order is reached.
 */
class OrderLimitReachedException extends \RuntimeException implements HttpExceptionInterface
{
    /**
     * @inheritdoc
     */
    public function getStatusCode(): int
    {
        return HttpCodesInterface::TOO_MANY_REQUESTS;
    }

    /**
     * @inheritdoc
     */
    public function getHeaders(): array
    {
        return [];
    }
}
