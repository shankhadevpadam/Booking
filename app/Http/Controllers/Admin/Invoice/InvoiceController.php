<?php

namespace App\Http\Controllers\Admin\Invoice;

use App\Http\Controllers\Controller;
use App\Models\UserPackagePayment;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function __invoke(UserPackagePayment $userPackagePayment)
    {
        abort_unless(auth()->user()->can('view_invoices'), 403, 'This action is unauthorized.');

        $userPackagePayment->load(['userPackage:id,user_id,package_id,number_of_trekkers,start_date,end_date,total_amount']);

        return PDF::loadview('pdf.payment_invoice', $userPackagePayment->toArray())->setWarnings(false)->stream();
    }
}
