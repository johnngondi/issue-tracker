<?php

namespace App\Models;

use Database\Factories\SystemFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\System
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property string|null $description
 * @property string|null $repository_link
 * @property string|null $repository_api_code
 * @property string|null $dev_branch
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection|Issue[]|HasMany|mixed issues
 * @property Collection|Issue[]|HasMany|mixed users
 * @property Collection|Tag[]|HasMany|mixed tags
 * @method static SystemFactory factory(...$parameters)
 * @method static Builder|System newModelQuery()
 * @method static Builder|System newQuery()
 * @method static Builder|System query()
 * @method static Builder|System whereCreatedAt($value)
 * @method static Builder|System whereDescription($value)
 * @method static Builder|System whereDevBranch($value)
 * @method static Builder|System whereId($value)
 * @method static Builder|System whereName($value)
 * @method static Builder|System whereRepositoryApiCode($value)
 * @method static Builder|System whereRepositoryLink($value)
 * @method static Builder|System whereSlug($value)
 * @method static Builder|System whereStatus($value)
 * @method static Builder|System whereUpdatedAt($value)
 * @method static System create(array $array)
 *
 */
class System extends Model
{
    use HasFactory;
    use HasApiTokens;

    protected $guarded = [];


    /**
     * @return Collection | Issue[] | HasMany
     */
    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class);
    }

    /**
     * @return Collection | User[] | BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('main');
    }

    /**
     * @return Collection | Tag[] | BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }
}
