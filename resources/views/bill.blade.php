@extends('layouts.app')

@section('title', 'Ticket View')

@section('content')
    {{-- Errors --}}
    @error('failedReq')
    <div class="order-error">
        <span>⚠️</span>
        {{ $message }}
    </div>
    @enderror

    {{-- Success --}}
    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <!-- Order Information -->
    <h1>Order #{{ $order['orderId'] }}</h1>
    <p>Amount Paid: {{ $order['amountPaid'] }}$</p>
    <p>Paid At: {{ $order['paidAt'] }} </p>
    <p>Payment Method: {{ $order['paymentMethod'] }}</p>

    <!-- Customer Data -->
    <h2>Customer Information</h2>
    <p>Email: {{ $order['customerEmail'] }}</p>
    <p>Name: {{ $order['customerName'] }}</p>

    <!-- Tickets -->
    <h2>Tickets Generated</h2>

    <table>
        <thead>
        <tr>
            <td>ID</td>
            <td>Seat</td>
            <td>Event Name</td>
            <td>Showtime Start</td>
        </tr>
        </thead>
        <tbody>
        @foreach($order['tickets'] as $ticket)
            <tr>
                <td>{{ $ticket['ticketId'] }}</td>
                <td>{{ $ticket['seatLabel'] }}</td>
                <td>{{ $ticket['eventName'] }}</td>
                <td>{{ $ticket['showtimeStart'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Resend Email -->
    <a href="{{ route('bill.resend') }}">Resend Email</a>
@endsection
