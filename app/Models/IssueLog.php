<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\IssueLog
 *
 * @property int $id
 * @property int $issue_id
 * @property string $action
 * @property string $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|IssueLog newModelQuery()
 * @method static Builder|IssueLog newQuery()
 * @method static Builder|IssueLog query()
 * @method static Builder|IssueLog whereAction($value)
 * @method static Builder|IssueLog whereCreatedAt($value)
 * @method static Builder|IssueLog whereId($value)
 * @method static Builder|IssueLog whereIssueId($value)
 * @method static Builder|IssueLog whereMessage($value)
 * @method static Builder|IssueLog whereUpdatedAt($value)
 * @mixin
 */

class IssueLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * @return BelongsTo | Issue
     */
    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class);
    }

}
