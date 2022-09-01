<?php

namespace App\Models;

use Database\Factories\IssueFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Issue
 *
 * @property int $id
 * @property int $system_id
 * @property int|null $user_id
 * @property string $title
 * @property string|null $description
 * @property string $type
 * @property string|null $page_title
 * @property string|null $page_url
 * @property string|null $requester_name
 * @property string|null $requester_email
 * @property string|null $requester_dept
 * @property int $status
 * @property int|null $days
 * @property string|null $assigned_at
 * @property string|null $planned_start_at
 * @property string|null $started_at
 * @property string|null $completed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property User | BelongsTo $user
 * @property System | BelongsTo $system
 * @property IssueLog[] | HasMany | Collection $logs
 * @method static IssueFactory factory(...$parameters)
 * @method static Builder|Issue newModelQuery()
 * @method static Builder|Issue newQuery()
 * @method static Builder|Issue query()
 * @method static Builder|Issue whereAssignedAt($value)
 * @method static Builder|Issue whereCompletedAt($value)
 * @method static Builder|Issue whereCreatedAt($value)
 * @method static Builder|Issue whereDays($value)
 * @method static Builder|Issue whereDescription($value)
 * @method static Builder|Issue whereId($value)
 * @method static Builder|Issue wherePageTitle($value)
 * @method static Builder|Issue wherePageUrl($value)
 * @method static Builder|Issue wherePlannedStartAt($value)
 * @method static Builder|Issue whereRequesterDept($value)
 * @method static Builder|Issue whereRequesterEmail($value)
 * @method static Builder|Issue whereRequesterName($value)
 * @method static Builder|Issue whereStartedAt($value)
 * @method static Builder|Issue whereStatus($value)
 * @method static Builder|Issue whereSystemId($value)
 * @method static Builder|Issue whereTitle($value)
 * @method static Builder|Issue whereType($value)
 * @method static Builder|Issue whereUpdatedAt($value)
 * @method static Builder|Issue whereUserId($value)
 * @method static Builder|Issue where(string $column, string $condition, $value)
 * @method static Issue create(array $array)
 *
 */

class Issue extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return User | BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return User | BelongsTo
     */
    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }

    /**
     * @return HasMany | IssueLog[] | Collection
     */
    public function logs(): HasMany
    {
        return $this->hasMany(IssueLog::class);
    }
}
