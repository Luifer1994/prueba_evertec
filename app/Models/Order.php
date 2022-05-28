<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 *
 * @property int $id
 * @property int $client_id
 * @property float $total
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Client $client
 * @property Collection|OrderLine[] $order_lines
 *
 * @package App\Models
 */
class Order extends Model
{
    use HasFactory;

	protected $table = 'orders';

	protected $casts = [
		'client_id' => 'int',
		'total' => 'float'
	];

	protected $fillable = [
		'client_id',
		'total',
		'status'
	];

	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function order_lines()
	{
		return $this->hasMany(OrderLine::class);
	}
}
