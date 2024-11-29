<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Group extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, SoftDeletes;

    /**
     * Get the post that owns the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['user_id', 'name', 'deleted_at'];

    /**

     * The users that belong to the role.

     */

    public function userGroups()
    {
        return $this->belongsToMany(User::class, 'group_users');
    }

    public function scopeOwnerOrInviteGroup($query)
    {
        return $query->select(['groups.*', 'group_users.accepted_invite'])
            ->join('group_users', 'groups.id', '=', 'group_users.group_id')
            ->where('groups.user_id', Auth::id())
            ->orWhere(function (Builder $query) {
                $query->where('group_users.user_id', Auth::id());
            })->distinct();
    }
}
