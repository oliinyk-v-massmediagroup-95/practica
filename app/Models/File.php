<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\File
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $name
 * @property string $ext
 * @property \Illuminate\Support\Carbon|null $delete_date
 * @property int $entry_counter
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $path
 * @property string $original_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Link[] $links
 * @property-read int|null $links_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Link[] $multi_time_links
 * @property-read int|null $multi_time_links_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Link[] $one_time_links
 * @property-read int|null $one_time_links_count
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File byUser(\App\User $user)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File findUserFile(\App\User $user, $file_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereDeleteDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereEntryCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereUserId($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\File onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\File withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\File withoutTrashed()
 */
class File extends Model
{
    use SoftDeletes;

    protected $table = 'files';
    protected $guarded = [];

    protected $casts = [
        'delete_date' => 'date'
    ];

    public function getFilePath(): string
    {
        return storage_path('app/public/'.$this->path);
    }

    public function getUrlPath(): string
    {
        return '/' . $this->path;
    }

    public function getCreatorComment(): ?Comment
    {
        return $this->comments->where('user_id', $this->user_id)->first();
    }

    public function scopeByUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeFindUserFile($query, User $user, $file_id)
    {
        return $query->where('user_id', $user->id)->where('id', $file_id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'files_comments');
    }

    public function multi_time_links()
    {
        return $this->hasMany(Link::class, 'file_id')->where('only_once', Link::MULTI_TIME_LINK);
    }

    public function one_time_links()
    {
        return $this->hasMany(Link::class, 'file_id')->where('only_once', Link::ONE_TIME_LINK);
    }

    public function links()
    {
        return $this->hasMany(Link::class, 'file_id');
    }
}
