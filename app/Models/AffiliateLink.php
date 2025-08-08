<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * App\Models\AffiliateLink
 *
 * @property int $id
 * @property int $user_id
 * @property int $program_id
 * @property string $tracking_code
 * @property string $link_url
 * @property int $clicks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Program $program
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateLink whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateLink whereProgramId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateLink whereTrackingCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateLink whereLinkUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateLink whereClicks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AffiliateLink whereUpdatedAt($value)
 * @method static \Database\Factories\AffiliateLinkFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class AffiliateLink extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'program_id',
        'tracking_code',
        'link_url',
        'clicks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'clicks' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'affiliate_links';

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($affiliateLink) {
            if (empty($affiliateLink->tracking_code)) {
                $affiliateLink->tracking_code = static::generateUniqueTrackingCode();
            }
            
            if (empty($affiliateLink->link_url)) {
                $affiliateLink->link_url = static::generateLinkUrl(
                    $affiliateLink->tracking_code,
                    $affiliateLink->program_id
                );
            }
        });
    }

    /**
     * Generate a unique tracking code.
     */
    protected static function generateUniqueTrackingCode(): string
    {
        do {
            $code = 'EB' . strtoupper(Str::random(8));
        } while (static::where('tracking_code', $code)->exists());

        return $code;
    }

    /**
     * Generate the full affiliate link URL.
     */
    protected static function generateLinkUrl(string $trackingCode, int $programId): string
    {
        return url('/affiliate/' . $trackingCode . '/program/' . $programId);
    }

    /**
     * Get the affiliate user that owns this link.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the program this link is for.
     */
    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    /**
     * Increment the click count.
     */
    public function recordClick(): void
    {
        $this->increment('clicks');
    }
}