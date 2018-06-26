<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Total extends Model
{
    protected $fillable = [
        'site_id',
        'month',
        'clicks',
        'impressions',
        'ctr',
        'position',
        'memo',
    ];

    protected $dates = [
        'month',
        'memo_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
