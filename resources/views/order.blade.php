@extends("layouts.app")
@section('title', 'Confirmacion de Orden')

<!-- Errors Displaying -->
@error('failedReq')
    <p>{{ $message }}</p>
@enderror

<!-- Order Details -->
<h2>Order Id #{{ $order['id'] }}</h2>
<p>User Email: {{ $order['userEmail'] }}</p>
<p>Generated at: {{ $order['createdAt'] }}</p>
<p>
    Status:
    @if($order['status'] == 0)
        Pending
    @elseif($order['status'] == 1)
        Completed
    @elseif($order['status'] == 2)
        Cancelled
    @endif
</p>

<!-- Tickets Data -->
<h3>Tickets to Buy</h3>
<table>
    <thead>
    <tr>
        <td>ID</td>
        <td>Seat Label</td>
        <td>Event Name</td>
        <td>Showtime Init Hour</td>
    </tr>
    </thead>
    @foreach($order['items'] as $item)
        <tr>
            <td>{{ $item['id'] }}</td>
            <td>{{ $item['seatLabel'] }}</td>
            <td>{{ $item['eventName'] }}</td>
            <td>{{ $item['showtimeStart'] }}</td>
        </tr>
    @endforeach
</table>

<p>Total Price: {{ $order['total'] }}</p>

<!-- Actions -->
@if($order['status'] == 0)
    <a href="{{ route('order.confirm', request()->route("id")) }}">Confirmar Orden</a>
    <a href="{{ route('order.cancel', request()->route("id")) }}">Cancelar</a>
@else
    <p>Order already closed</p>
@endif
