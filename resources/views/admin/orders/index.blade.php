@extends('adminlte::page')

@section('title', 'Orders')

@section('content')

<div class="card">

    <div class="card-header">

        <div class="d-flex justify-content-between mb-3">
            <h2>Order List</h2>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-0">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-0 mt-2">
                {{ $errors->first() }}
            </div>
        @endif

    </div>

    <div class="card-body">

        <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search order number, customer or email"
                        value="{{ $filters['search'] ?? '' }}"
                    >
                </div>

                <div class="col-md-2">
                    <select name="order_status" class="form-control">
                        <option value="">All Order Status</option>
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['order_status'] ?? '') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="payment_status" class="form-control">
                        <option value="">All Payment Status</option>
                        @foreach($paymentStatuses as $value => $label)
                            <option value="{{ $value }}" @selected(($filters['payment_status'] ?? '') === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        Filter
                    </button>

                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive">

            <table class="table table-bordered table-striped">

                <thead>
                    <tr>
                        <th>Sr</th>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Grand Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $orders->firstItem() + $loop->index }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td>
                                <strong>{{ $order->user->name ?? '-' }}</strong>
                                <br>
                                <small>{{ $order->user->email ?? '-' }}</small>
                            </td>
                            <td>{{ $order->items->sum('quantity') }}</td>
                            <td>{{ number_format((float) $order->grand_total, 2) }}</td>
                            <td>
                                <span class="badge badge-secondary">
                                    {{ ucfirst($order->payment_method) }}
                                </span>
                                <span class="badge badge-light">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $service->statusBadgeClass($order->order_status) }}">
                                    {{ $statuses[$order->order_status] ?? ucfirst($order->order_status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at?->format('Y-m-d H:i') }}</td>
                            <td>
                                @can('orders.view')
                                    <a
                                        href="{{ route('admin.orders.show', $order->id) }}"
                                        class="btn btn-info btn-sm"
                                    >
                                        View
                                    </a>
                                @endcan

                                @can('orders.update-status')
                                    <form
                                        action="{{ route('admin.orders.update-status', $order->id) }}"
                                        method="POST"
                                        class="d-inline-block mt-1"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <div class="input-group input-group-sm" style="min-width: 190px;">
                                            <select name="order_status" class="form-control">
                                                @foreach($statuses as $value => $label)
                                                    <option value="{{ $value }}" @selected($order->order_status === $value)>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">
                                                    Update
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>

        <div class="mt-3">
            {{ $orders->links() }}
        </div>

    </div>

</div>

@endsection
