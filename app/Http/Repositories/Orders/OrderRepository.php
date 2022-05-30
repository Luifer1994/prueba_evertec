<?php

namespace App\Http\Repositories\Orders;

use App\Http\Repositories\BaseRepository;
use App\Models\Order;

class OrderRepository extends BaseRepository
{

    const RELATIONSHIP = ['client.document_type', 'order_lines.product'];


    function __construct(Order $order)
    {
        parent::__construct($order, self::RELATIONSHIP);
    }

    public function all(int $limit)
    {
        return $this->model::select('*')
            ->with('user.employee', 'area', 'image_findings')
            ->withCount('tracings')
            ->orderBy('findings.id', 'DESC')
            ->paginate($limit);
    }

    public function getUuid(string $uuid)
    {
        $query = $this->model;
        if (!empty($this->relationships)) {
            $query =   $query->with($this->relationships);
        }
        return $query->where('uuid', $uuid)->first();
    }
}
