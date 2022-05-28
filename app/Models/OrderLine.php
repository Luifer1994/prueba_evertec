<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderLine
 *
 * @property int $id
 * @property int $product_id
 * @property int $order_id
 * @property int $quantity
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Order $order
 * @property Product $product
 *
 * @package App\Models
 */
class OrderLine extends Model
{
    use HasFactory;

	protected $table = 'order_lines';

	protected $casts = [
		'product_id' => 'int',
		'order_id' => 'int',
		'quantity' => 'int'
	];

	protected $fillable = [
		'product_id',
		'order_id',
		'quantity'
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
