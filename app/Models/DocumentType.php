<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentType
 *
 * @property int $id
 * @property string $cod
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Client[] $clients
 *
 * @package App\Models
 */
class DocumentType extends Model
{
    use HasFactory;

    protected $table = 'document_types';

    protected $fillable = [
        'cod',
        'name'
    ];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
