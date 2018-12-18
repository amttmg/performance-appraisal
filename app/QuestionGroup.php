<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class QuestionGroup
 * @package App
 */
class QuestionGroup extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title', 'parent_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class, 'group_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(QuestionGroup::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(QuestionGroup::class, 'parent_id');
    }
}
