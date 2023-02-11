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
            $filteredRefundPayments = $userPackage->payments->filter(function ($item) {
                return str_contains($item->payment_type, 'refund');
            });
        @endphp

        @forelse ($filteredRefundPayments->all() as $payment)
            <tr>
                <td>{{ ucfirst($payment->payment_method) }}</td>
                <td>{{ number_format($payment->amount, 2) }}</td>
                <td>{{ $payment->notes }}</td>
                <td>{{ $payment->created_at->toDateString() }}</td>
                @can('view_clients')
                    <td>
                        <span class="btn btn-sm btn-danger" onclick="confirmComponentItemDelete({{ $payment->id }}, 'deleteRefundPaymentHistory')">Delete</span>
                    </td> 
                @endcan
            </tr>
        @empty
            <tr>
                <td colspan="5">No record available.</td>
            </tr>
        @endforelse
    </tbody>
</table>
