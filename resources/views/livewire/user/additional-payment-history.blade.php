<table class="table table-hover">
    <thead>
        <tr>
            <th>Payment Method</th>
            <th>Amount</th>
            <th>Notes</th>
            <th>Date</th>
            @can('view_clients')
              <th>Action</th>  
            @endcan
        </tr>
    </thead>
    <tbody>
        @php
            $filteredAdditionalPayments = $userPackage->payments->filter(function ($item) {
                return str_contains($item->payment_type, 'additional');
            });
        @endphp

        @forelse ($filteredAdditionalPayments->all() as $payment)
            <tr>
                <td>{{ ucfirst($payment->payment_method) }}</td>
                <td>{{ number_format($payment->amount, 2) }}</td>
                <td>{{ $payment->notes }}</td>
                <td>{{ $payment->created_at->toDateString() }}</td>
                <td>
                    @can('view_clients')
                        <a class="btn btn-sm btn-success" href="{{ route('admin.invoice', $payment->id) }}">View Invoice</a>
                        <span class="btn btn-sm btn-primary" wire:click="resendInvoice('{{ $payment->id }}')">Resend Invoice</span>
                        <span class="btn btn-sm btn-danger" onclick="confirmComponentItemDelete({{ $payment->id }}, 'deleteAdditionalPaymentHistory')">Delete</span>
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
