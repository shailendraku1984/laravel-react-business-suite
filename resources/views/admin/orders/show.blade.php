@extends('adminlte::page')

@section('title', 'Order Details')

@section('content')

<div class="mb-3">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        Back to Orders
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    {{ $order->order_number }}
                </h3>

                <span class="badge {{ $service->statusBadgeClass($order->order_status) }}">
                    {{ $statuses[$order->order_status] ?? ucfirst($order->order_status) }}
                </span>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 220px;">Customer</th>
                            <td>
                                {{ $order->user->name ?? '-' }}
                                <br>
                                <small>{{ $order->user->email ?? '-' }}</small>
                            </td>
                        </tr>
                        <tr>
                            <th>Payment Method</th>
                            <td>{{ ucfirst($order->payment_method) }}</td>
                        </tr>
                        <tr>
                            <th>Payment Status</th>
                            <td>{{ ucfirst($order->payment_status) }}</td>
                        </tr>
                        <tr>
                            <th>Order Date</th>
                            <td>{{ $order->created_at?->format('Y-m-d H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Notes</th>
                            <td>{{ $order->notes ?: '-' }}</td>
                        </tr>
                    </tbody>
                </table>

                @can('orders.update-status')
                    <form
                        action="{{ route('admin.orders.update-status', $order->id) }}"
                        method="POST"
                        class="mt-3"
                    >
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-md-6">
                                <select name="order_status" class="form-control">
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" @selected($order->order_status === $value)>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Update Status
                                </button>
                            </div>
                        </div>
                    </form>
                @endcan
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">Order Items</h3>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->sku ?? '-' }}</td>
                                <td>{{ number_format((float) $item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format((float) $item->total, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No items found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">Totals</h3>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span>Subtotal</span>
                    <strong>{{ number_format((float) $order->subtotal, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Tax</span>
                    <strong>{{ number_format((float) $order->tax_amount, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Shipping</span>
                    <strong>{{ number_format((float) $order->shipping_amount, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Discount</span>
                    <strong>{{ number_format((float) $order->discount_amount, 2) }}</strong>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Grand Total</span>
                    <strong>{{ number_format((float) $order->grand_total, 2) }}</strong>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">Shipping Address</h3>
            </div>

            <div class="card-body">
                @if($order->shippingAddress)
                    <strong>{{ $order->shippingAddress->full_name }}</strong>
                    <p class="mb-1">{{ $order->shippingAddress->phone }}</p>
                    <p class="mb-1">{{ $order->shippingAddress->address_line_1 }}</p>
                    <p class="mb-1">{{ $order->shippingAddress->address_line_2 }}</p>
                    <p class="mb-0">
                        {{ collect([
                            $order->shippingAddress->city,
                            $order->shippingAddress->state,
                            $order->shippingAddress->country,
                            $order->shippingAddress->zip_code,
                        ])->filter()->implode(', ') }}
                    </p>
                @else
                    -
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0">Billing Address</h3>
            </div>

            <div class="card-body">
                @if($order->billingAddress)
                    <strong>{{ $order->billingAddress->full_name }}</strong>
                    <p class="mb-1">{{ $order->billingAddress->phone }}</p>
                    <p class="mb-1">{{ $order->billingAddress->address_line_1 }}</p>
                    <p class="mb-1">{{ $order->billingAddress->address_line_2 }}</p>
                    <p class="mb-0">
                        {{ collect([
                            $order->billingAddress->city,
                            $order->billingAddress->state,
                            $order->billingAddress->country,
                            $order->billingAddress->zip_code,
                        ])->filter()->implode(', ') }}
                    </p>
                @else
                    Same as shipping or not provided.
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
