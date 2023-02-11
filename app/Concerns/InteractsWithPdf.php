<?php

namespace App\Concerns;

use Barryvdh\DomPDF\Facade\Pdf;

trait InteractsWithPdf
{
    /** @var pdf */
    protected $pdf;

    /**
     * Generate pdf output
     *
     * @return void
     */
    public function makePdf(): void
    {
        $userPackage = $this->userPackage->toArray();

        $userPackage['amount'] = $this->amount;

        $userPackage['payment_method'] = $this->paymentMethod;

        $this->pdf = PDF::loadview('pdf.internal_payment_invoice', $userPackage)->setWarnings(false)->output();
    }
}
