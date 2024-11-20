<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\Exceptions\BusinessException;
use App\Contracts\Responses\JsonResponse;
use App\Http\Controllers\Requests\API\V1\PayRequest;
use App\Http\Controllers\Requests\API\V1\VerifyRequest;
use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\Payment\Models\InvoiceID;
use App\Modules\Payment\Services\PaymentService\NewPayment;
use App\Modules\Payment\Services\PaymentService\PaymentService;
use Illuminate\Http\Response;

readonly class UserPaymentController
{
    public function __construct(
        private PaymentService $paymentService,
    )
    {
    }

    public function pay(PayRequest $request): Response
    {
        $invoiceID = $request->get('invoice_id');
        $paymentMethod = $request->get('method');
        try {
            $newPayment = new NewPayment(
                new InvoiceID($invoiceID),
                PaymentMethod::from($paymentMethod)
            );

            $this->paymentService->pay($newPayment);
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('paid');
    }

    public function verify(VerifyRequest $request): Response
    {
        $invoiceID = $request->get('invoice_id');
        try {
            $this->paymentService->verify(new InvoiceID($invoiceID));
        } catch (BusinessException $exception) {
            return JsonResponse::unprocessableEntity($exception->getMessage());
        }

        return JsonResponse::created('verified');
    }
}
