<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

use Revolution\Google\SearchConsole\Traits\SearchConsole;

class Site extends Model
{
    use SoftDeletes;
    use Notifiable;
    use SearchConsole;

    protected $fillable = [
        'url',
        'user_id',
        'access_token',
        'refresh_token',
        'title',
        'group',
        'password',
        'fails',
    ];

    protected $dates = [
        'deleted_at',
    ];

    /**
     * Get the Access Token
     *
     * @return string|array
     */
    protected function tokenForSearchConsole()
    {
        return [
            'access_token'  => $this->access_token,
            'refresh_token' => $this->refresh_token,
            'expires_in'    => 3600,
            'created'       => now()->subDay()->getTimestamp(),
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function totals()
    {
        return $this->hasMany(Total::class);
    }
}
