<?php

namespace Lash\Domain\Product\Exception;

use App\Http\HttpCodesInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Thrown when product is not found.
 */
class ProductNotFoundException extends \RuntimeException implements HttpExceptionInterface
{
    /**
     * @inheritdoc
     */
    public function getStatusCode(): int
    {
        return HttpCodesInterface::NOT_FOUND;
    }

    /**
     * @inheritdoc
     */
    public function getHeaders(): array
    {
        return [];
    }
}
