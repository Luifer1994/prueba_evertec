<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Client
 *
 * @property int $id
 * @property int $document_type_id
 * @property string $document_number
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string $phone
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property DocumentType $document_type
 * @property Collection|Order[] $orders
 *
 * @package App\Models
 */
class Client extends Model
{
    use HasFactory;

	protected $table = 'clients';

	protected $casts = [
		'document_type_id' => 'int'
	];

	protected $fillable = [
		'document_type_id',
		'document_number',
		'name',
		'last_name',
		'email',
		'phone'
	];

	public function document_type()
	{
		return $this->belongsTo(DocumentType::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class);
	}
}
