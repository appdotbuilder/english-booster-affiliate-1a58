<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CommissionPayout
 *
 * @property int $id
 * @property int $affiliate_id
 * @property float $amount
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $processed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $affiliate
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|CommissionPayout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommissionPayout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommissionPayout query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommissionPayout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommissionPayout whereAffiliateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommissionPayout whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommissionPayout whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommissionPayout whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommissionPayout whereProcessedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommissionPayout whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommissionPayout whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommissionPayout pending()
 * @method static \Illuminate\Database\Eloquent\Builder|CommissionPayout paid()
 * @method static \Database\Factories\CommissionPayoutFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class CommissionPayout extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'affiliate_id',
        'amount',
        'status',
        'notes',
        'processed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commission_payouts';

    /**
     * Scope a query to only include pending payouts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include paid payouts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Get the affiliate for this payout.
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    /**
     * Get formatted amount with currency.
     */
    public function getFormattedAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'paid' => 'green',
            'processing' => 'blue',
            'pending' => 'yellow',
            'cancelled' => 'red',
            default => 'gray'
        };
    }
}