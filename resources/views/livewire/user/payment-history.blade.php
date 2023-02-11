<table class="table table-hover">
    <thead>
        <tr>
            <th>Payment Method</th>
            <th>Payment Type</th>
            <th>Amount</th>
            <th>Bank Charge</th>
            <th>Total Amount</th>
            <th>Date</th>
            @can('view_clients')
                <th>Action</th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @php
            $filteredPayments = $userPackage->payments->filter(function ($item) {
                return !(str_contains($item->payment_type, 'additional') || str_contains($item->payment_type, 'refund'));
            });
        @endphp
        
        @forelse ($filteredPayments as $payment)
            <tr>
                <td>{{ str($payment->payment_method)->headline() }}</td>
                <td>{{ str($payment->payment_type)->headline() }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->bank_charge }}</td>
                <td>{{ $payment->amount + $payment->bank_charge }}</td>
                <td>{{ $payment->created_at->toDateString() }}</td>
                <td>
                    @role('Client')
                        <a class="btn btn-sm btn-success" href="{{ route('invoice', $payment->id) }}" target="_blank">View Invoice</a>
                    @else
                        <a class="btn btn-sm btn-success" href="{{ route('admin.invoice', $payment->id) }}" target="_blank">View Invoice</a>
                    @endrole

                    @can('view_clients')
                        <span class="btn btn-sm btn-primary" wire:click="resendInvoice('{{ $payment->id }}')">Resend Invoice</span>
                        <span class="btn btn-sm btn-danger" onclick="deletePaymentHistory({{ $payment->id }})">Delete</span>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No record available.</td>
            </tr>
        @endforelse
    </tbody>
</table>
