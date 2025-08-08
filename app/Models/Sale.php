<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Sale
 *
 * @property int $id
 * @property int $affiliate_id
 * @property int $program_id
 * @property string $tracking_code
 * @property string $customer_name
 * @property string $customer_email
 * @property string|null $customer_phone
 * @property float $sale_amount
 * @property float $commission_rate
 * @property float $commission_amount
 * @property string $status
 * @property \Illuminate\Support\Carbon $sale_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $affiliate
 * @property-read \App\Models\Program $program
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Sale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereAffiliateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereTrackingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCustomerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCustomerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCustomerPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereSaleAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCommissionRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCommissionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereSaleDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sale confirmed()
 * @method static \Illuminate\Database\Eloquent\Builder|Sale pending()
 * @method static \Database\Factories\SaleFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Sale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'affiliate_id',
        'program_id',
        'tracking_code',
        'customer_name',
        'customer_email',
        'customer_phone',
        'sale_amount',
        'commission_rate',
        'commission_amount',
        'status',
        'sale_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sale_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'sale_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sales';

    /**
     * Scope a query to only include confirmed sales.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include pending sales.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Get the affiliate that made this sale.
     */
    public function affiliate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    /**
     * Get the program for this sale.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Get formatted sale amount with currency.
     */
    public function getFormattedSaleAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->sale_amount, 0, ',', '.');
    }

    /**
     * Get formatted commission amount with currency.
     */
    public function getFormattedCommissionAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->commission_amount, 0, ',', '.');
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'green',
            'pending' => 'yellow',
            'cancelled' => 'red',
            default => 'gray'
        };
    }
}