<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Program
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $category
 * @property string|null $location
 * @property float $price
 * @property float $commission_percentage
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AffiliateLink[] $affiliateLinks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Sale[] $sales
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Program newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Program newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Program query()
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereCommissionPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Program active()
 * @method static \Illuminate\Database\Eloquent\Builder|Program byCategory($category)
 * @method static \Database\Factories\ProgramFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Program extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'category',
        'location',
        'price',
        'commission_percentage',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'commission_percentage' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'programs';

    /**
     * Scope a query to only include active programs.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter by category.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $category
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get the affiliate links for this program.
     */
    public function affiliateLinks(): HasMany
    {
        return $this->hasMany(AffiliateLink::class);
    }

    /**
     * Get the sales for this program.
     */
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Get formatted price with currency.
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Calculate commission amount for a given sale price.
     */
    public function calculateCommission(float $salePrice): float
    {
        return ($salePrice * $this->commission_percentage) / 100;
    }
}