<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Answer
 * @package App
 */
class Answer extends Model
{
    protected $fillable = ['question_id', 'rating', 'feedback'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
