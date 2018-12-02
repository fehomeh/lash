<?php

namespace Lash\Domain\Product\Exception;

use App\Http\HttpCodesInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Thrown when incorrect product size is given.
 */
class WrongSizeException extends \DomainException implements HttpExceptionInterface
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
