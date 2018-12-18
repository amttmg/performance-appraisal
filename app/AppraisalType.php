<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppraisalType
 * @package App
 */
class AppraisalType extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * @return mixed
     */
    public function getAppraiseTypeAttribute()
    {
        return $this->where('title', 'supervisor')->firstOrFail();
    }
}
