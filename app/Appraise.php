<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

/**
 * Class Appraise
 * @package App
 */
class Appraise extends Model
{
    /**
     * @var string
     */
    protected $table = 'appraise';

    /**
     * @var array
     */
    protected $fillable = ['session_id', 'appraisal_of', 'appraisal_by', 'type_id', 'is_completed'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appraiseOf()
    {
        return $this->belongsTo(User::class, 'appraisal_of');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appraiseBy()
    {
        return $this->belongsTo(User::class, 'appraisal_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(AppraisalType::class, 'type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appraisalSession()
    {
        return $this->belongsTo(AppraisalSession::class, 'session_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function strengthVsWeakness()
    {
        return $this->hasOne(StrengthVsWeakness::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
