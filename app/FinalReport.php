<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FinalReport
 * @package App
 */
class FinalReport extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['session_id', 'report', 'is_published'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
