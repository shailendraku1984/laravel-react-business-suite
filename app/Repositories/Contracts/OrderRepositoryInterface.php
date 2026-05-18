<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface OrderRepositoryInterface
{
    public function paginate(array $filters = [], int $perPage = 10): LengthAwarePaginator;

    public function findForAdmin(Order $order): Order;

    public function updateStatus(Order $order, string $status): Order;
}
