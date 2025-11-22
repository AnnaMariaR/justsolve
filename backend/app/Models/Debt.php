<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Debt model.
 *
 * @property int $id
 * @property string $external_id
 * @property string $debtor_name
 * @property float $amount
 * @property int $days_overdue
 * @property string $status
 * @property string|null $last_action
 * @property Carbon|null $last_action_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|Debt where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Debt|null find($id, $columns = ['*'])
 * @method static Debt findOrFail($id, $columns = ['*'])
 * @method static Collection|Debt[] get($columns = ['*'])
 * @method static Debt create(array $attributes = [])
 *
 * @mixin Builder
 */
class Debt extends Model
{
    protected $fillable = [
        'external_id',
        'debtor_name',
        'amount',
        'days_overdue',
        'status',
        'last_action',
        'last_action_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'days_overdue' => 'integer',
        'last_action_at' => 'datetime',
    ];
}
