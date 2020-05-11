<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static paginate(int $COUNT_SECTIONS_PAGE)
 * @property int id
 * @property string logo
 * @property string description
 * @property string name
 */
class Section extends Model
{
    protected $fillable = ['name', 'description', 'logo'];
    public $timestamps = false;

    /**
     * Get section users
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'section_users');
    }
}
