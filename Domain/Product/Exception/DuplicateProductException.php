<?php

namespace Lash\Domain\Product\Exception;

use App\Http\HttpCodesInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Thrown when product of such type, size and color already exists.
 */
class DuplicateProductException extends \DomainException implements HttpExceptionInterface
{
    /**
     * @inheritdoc
     */
    public function getStatusCode(): int
    {
        return HttpCodesInterface::CONFLICT;
    }

    /**
     * @inheritdoc
     */
    public function getHeaders(): array
    {
        return [];
    }
}
