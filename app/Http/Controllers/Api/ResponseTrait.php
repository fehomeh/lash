<?php

namespace App\Http\Controllers\Api;

use App\Http\HttpCodesInterface;
use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    /**
     * @param array $errors
     * @return JsonResponse
     */
    private function createValidationError(array $errors): JsonResponse
    {
        return new JsonResponse(['success' => false, 'message' => $errors], HttpCodesInterface::PRECONDITION_FAILED);
    }
}
