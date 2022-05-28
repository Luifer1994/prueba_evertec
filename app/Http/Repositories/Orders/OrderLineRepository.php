<?php

namespace App\Http\Repositories\Orders;

use App\Http\Repositories\BaseRepository;
use App\Models\OrderLine;

class OrderLineRepository extends BaseRepository
{

    const RELATIONSHIP = ['order.client', 'product'];


    function __construct(OrderLine $orderLine)
    {
        parent::__construct($orderLine, self::RELATIONSHIP);
    }

    public function all(int $limit)
    {
        return $this->model::select('*')
            ->with('user.employee', 'area', 'image_findings')
            ->withCount('tracings')
            ->orderBy('findings.id', 'DESC')
            ->paginate($limit);
    }
}
