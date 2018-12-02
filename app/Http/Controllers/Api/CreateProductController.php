<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use \App\UseCase\Product\CreateProduct;
use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Validation\Validator;

class CreateProductController extends Controller
{
    use ResponseTrait;
    /**
     * @var CreateProduct
     */
    private $createUseCase;

    /**
     * CreateProductController constructor.
     * @param CreateProduct $createUseCase
     */
    public function __construct(CreateProduct $createUseCase)
    {
        $this->createUseCase = $createUseCase;
    }

    /**
     * Creates product and returns its UUID.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $validator = $this->createValidator($request);
        $validator->passes();
        $errors = $validator->errors();
        if ($errors->count()) {
            return $this->createValidationError($errors->toArray());
        }

        $product = $this->createUseCase->execute(
            $request->request->get('price'),
            $request->request->get('product_type'),
            $request->request->get('color'),
            $request->request->get('size')
        );

        return new JsonResponse(['success' => true, 'data' => ['uuid' => $product->getId()->toString()]]);
    }

    /**
     * @param Request $request
     *
     * @return Validator
     */
    private function createValidator(Request $request): Validator
    {
        return ValidatorFacade::make(
            $request->request->all(),
            [
                'price' => 'required|gt:0',
                'product_type' => 'required|max:255',
                'color' => 'required|max:30',
                'size' => 'required|max:5',
            ]
        );
    }
}
