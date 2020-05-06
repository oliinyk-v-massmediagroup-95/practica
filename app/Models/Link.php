<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Link
 *
 * @property int $id
 * @property string $token
 * @property int $file_id
 * @property int $only_once
 * @property int $entry_counter
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property-read \App\Models\File $file
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereEntryCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereFileId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereOnlyOnce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link whereUserId($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link onlyReusable()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link onlyTemporary()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link notVisited()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link visited()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Link byUser(\App\User $user)
 */
class Link extends Model
{
    protected $table = 'links';
    protected $guarded = [];

    public const ONE_TIME_LINK = 1;
    public const MULTI_TIME_LINK = 0;

    public function scopeVisited($query)
    {
        return $query->where('entry_counter', '>', 0);
    }

    public function scopeNotVisited($query)
    {
        return $query->where('entry_counter', 0);
    }

    public function scopeOnlyTemporary($query)
    {
        return $query->where('only_once', self::ONE_TIME_LINK);
    }

    public function scopeByUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeOnlyReusable($query)
    {
        return $query->where('only_once', self::MULTI_TIME_LINK);
    }

    public function isOneTimeLink(): bool
    {
        return $this->only_once === self::ONE_TIME_LINK;
    }

    public function hasBeenVisited(): bool
    {
        return $this->entry_counter > 0;
    }

    public function getGeneratedLink(): string
    {
        return route('token.link', ['token' => $this->token]);
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
