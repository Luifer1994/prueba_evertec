<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @property int $id
 * @property string $image
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|OrderLine[] $order_lines
 *
 * @package App\Models
 */
class Product extends Model
{
    use HasFactory;

	protected $table = 'products';

	protected $casts = [
		'price' => 'float'
	];

	protected $fillable = [
		'image',
		'name',
		'description',
		'price'
	];

	public function order_lines()
	{
		return $this->hasMany(OrderLine::class);
	}
}
