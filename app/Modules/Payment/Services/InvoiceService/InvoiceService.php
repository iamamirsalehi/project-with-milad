<?php

namespace App\Modules\Payment\Services\InvoiceService;

use App\Contracts\Repositories\IInvoiceRepository;
use App\Modules\Payment\Enums\InvoiceType;
use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Models\Invoice;
use App\Modules\Payment\Models\InvoiceID;

readonly class InvoiceService
{
    public function __construct(private IInvoiceRepository $invoiceRepository)
    {
    }

    /**
     * @throws PaymentApplicationException
     */
    public function add(NewInvoice $data): InvoiceID
    {
        $userLatestInvoice = $this->invoiceRepository->findByUserIDAndType($data->getUserID(), $data->getInvoiceType(), $data->getInvoiceTypeID());
        if (false === is_null($userLatestInvoice) && false === $userLatestInvoice->isPaid()) {
            throw PaymentApplicationException::canNotHaveTwoUnpaidInvoice();
        }

        $invoice = Invoice::new(
            $data->getUserID(),
            InvoiceType::Rent,
            $data->getInvoiceTypeID(),
            $data->getInvoicePrice()
        );

        $this->invoiceRepository->save($invoice);

        $userLatestInvoice = $this->invoiceRepository->findByUserIDAndType($data->getUserID(), $data->getInvoiceType(), $data->getInvoiceTypeID());

        return $userLatestInvoice->id;
    }
}
