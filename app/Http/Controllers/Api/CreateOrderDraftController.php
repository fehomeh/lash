<?php

namespace App\Http\Controllers\Api;

use App\UseCase\OrderDraft\CreateOrderDraft;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateOrderDraftController
{
    /**
     * @var CreateOrderDraft
     */
    private $createOrderDraft;

    /**
     * CreateOrderDraftController constructor.
     * @param CreateOrderDraft $createOrderDraft
     */
    public function __construct(CreateOrderDraft $createOrderDraft)
    {
        $this->createOrderDraft = $createOrderDraft;
    }

    /**
     * Creates new order and returns its sum.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $sum = $this->createOrderDraft->execute($request->request->get('products'), $request->getClientIp());

        return new JsonResponse(['status' => true, 'data' => ['sum' => $sum]]);
    }
}
