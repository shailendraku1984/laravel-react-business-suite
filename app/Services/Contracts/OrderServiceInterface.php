<?php

namespace App\Services\Contracts;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderServiceInterface
{
    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator;

    public function getOrder(Order $order): Order;

    public function updateStatus(Order $order, string $status): Order;

    public function statuses(): array;

    public function paymentStatuses(): array;

    public function statusBadgeClass(string $status): string;
}
