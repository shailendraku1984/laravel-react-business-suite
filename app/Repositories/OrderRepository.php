<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderRepository implements OrderRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return Order::with(['user', 'items'])
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('order_number', 'like', '%'.$search.'%')
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', '%'.$search.'%')
                                ->orWhere('email', 'like', '%'.$search.'%');
                        });
                });
            })
            ->when($filters['order_status'] ?? null, fn ($query, string $status) => $query->where('order_status', $status))
            ->when($filters['payment_status'] ?? null, fn ($query, string $status) => $query->where('payment_status', $status))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function findForAdmin(Order $order): Order
    {
        return $order->load([
            'user',
            'items.product',
            'shippingAddress',
            'billingAddress',
        ]);
    }

    public function updateStatus(Order $order, string $status): Order
    {
        $order->update([
            'order_status' => $status,
        ]);

        return $order->refresh();
    }
}
