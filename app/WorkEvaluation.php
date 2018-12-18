<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WorkEvaluation
 * @package App
 */
class WorkEvaluation extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['session_id', 'user_id', 'efficiency', 'productivity', 'total', 'remarks'];
    /**
     * @var string
     */
    protected $table = 'work_evaluation';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
