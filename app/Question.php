<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Question
 * @package App
 */
class Question extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['question','group_id'];

    protected $appends = ['error'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(QuestionGroup::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }

    public function getErrorAttribute()
    {
        return null;
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
