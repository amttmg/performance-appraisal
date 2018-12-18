<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AppraisalSession
 * @package App
 */
class AppraisalSession extends Model
{
    /**
     * @var string
     */
    protected $table = 'sessions';

    /**
     *
     */
    public function appraise()
    {
        $this->hasMany(Appraise::class);
    }
}
