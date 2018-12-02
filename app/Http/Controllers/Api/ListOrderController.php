<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\UseCase\OrderDraft\ListAllOrders;
use App\UseCase\OrderDraft\ListOrdersByType;
use Illuminate\Http\JsonResponse;

class ListOrderController extends Controller
{
    /**
     * @var ListAllOrders
     */
    private $listAllUseCase;

    /**
     * @var ListOrdersByType
     */
    private $listByTypeUseCase;

    /**
     * ListOrderController constructor.
     * @param ListAllOrders $listAllUseCase
     * @param ListOrdersByType $listByTypeUseCase
     */
    public function __construct(ListAllOrders $listAllUseCase, ListOrdersByType $listByTypeUseCase)
    {
        $this->listAllUseCase = $listAllUseCase;
        $this->listByTypeUseCase = $listByTypeUseCase;
    }

    /**
     * Returns array of all order drafts.
     *
     * @return JsonResponse
     */
    public function listAllAction(): JsonResponse
    {
        $result = $this->listAllUseCase->execute();

        return new JsonResponse(['success' => true, 'data' => $result]);
    }

    /**
     * Returns list of order drafts which has product of a given type.
     *
     * @param string $productType
     *
     * @return JsonResponse
     */
    public function listByProductTypeAction(string $productType): JsonResponse
    {
        $result = $this->listByTypeUseCase->execute($productType);

        return new JsonResponse(['success' => true, 'data' => $result]);
    }
}
