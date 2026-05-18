<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\Contracts\OrderServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderServiceInterface
{
    private const STATUSES = [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'processing' => 'Processing',
        'shipped' => 'Shipped',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled',
    ];

    private const PAYMENT_STATUSES = [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'failed' => 'Failed',
        'refunded' => 'Refunded',
    ];

    private const STATUS_BADGES = [
        'pending' => 'badge-warning',
        'confirmed' => 'badge-primary',
        'processing' => 'badge-primary',
        'shipped' => 'badge-info',
        'delivered' => 'badge-success',
        'cancelled' => 'badge-danger',
    ];

    public function __construct(
        protected OrderRepositoryInterface $repository
    ) {
    }

    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $perPage);
    }

    public function getOrder(Order $order): Order
    {
        return $this->repository->findForAdmin($order);
    }

    public function updateStatus(Order $order, string $status): Order
    {
        return DB::transaction(fn () => $this->repository->updateStatus($order, $status));
    }

    public function statuses(): array
    {
        return self::STATUSES;
    }

    public function paymentStatuses(): array
    {
        return self::PAYMENT_STATUSES;
    }

    public function statusBadgeClass(string $status): string
    {
        return self::STATUS_BADGES[$status] ?? 'badge-secondary';
    }
}
