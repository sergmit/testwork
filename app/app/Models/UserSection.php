<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int section_id
 * @property int user_id
 */
class UserSection extends Pivot
{
    protected $table = 'section_users';
    public $timestamps = false;
    protected $fillable = ['user_id', 'section_id'];
}
