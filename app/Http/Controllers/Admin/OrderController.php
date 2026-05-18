<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Services\Contracts\OrderServiceInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected OrderServiceInterface $service
    ) {
    }

    public function index(Request $request)
    {
        $filters = $request->only([
            'search',
            'order_status',
            'payment_status',
        ]);

        $orders = $this->service->paginate($filters);

        return view('admin.orders.index', [
            'orders' => $orders,
            'filters' => $filters,
            'statuses' => $this->service->statuses(),
            'paymentStatuses' => $this->service->paymentStatuses(),
            'service' => $this->service,
        ]);
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', [
            'order' => $this->service->getOrder($order),
            'statuses' => $this->service->statuses(),
            'service' => $this->service,
        ]);
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $this->service->updateStatus(
            $order,
            $request->validated('order_status')
        );

        return back()->with('success', 'Order status updated successfully.');
    }
}
