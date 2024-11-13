<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Employee class.

 * @property string $id
 * @property string $cpf
 * @property string $city
 * @property string $state
 * @property string $email
 * @property int $manager_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Employee extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'cpf',
        'city',
        'state',
        'manager_id',
        'id',
    ];

    public static function booted(): void
    {
        static::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
