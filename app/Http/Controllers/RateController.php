<?php

namespace App\Http\Controllers;

use App\Services\Contracts\RateServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * @var RateServiceInterface
     */
    private $rateService;

    public function __construct(RateServiceInterface $rateService)
    {
        $this->rateService = $rateService;
    }

    /**
     * @return JsonResponse
     */
    public function get(): JsonResponse
    {
        return new JsonResponse($this->rateService->getRates(), 200);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function convert(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'currency_from' => 'required',
            'currency_to' => 'required',
            'value' => 'required|numeric|min:0.01',
        ]);

        return new JsonResponse($this->rateService->convert($validated), 200);
    }
}
