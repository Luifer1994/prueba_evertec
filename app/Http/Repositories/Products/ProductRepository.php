<?php

namespace App\Http\Repositories\Products;

use App\Http\Repositories\BaseRepository;
use App\Models\Product;

class ProductRepository extends BaseRepository
{

    const RELATIONSHIP = [];

    function __construct(Product $product)
    {
        parent::__construct($product, self::RELATIONSHIP);
    }

}
