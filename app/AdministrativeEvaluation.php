<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AdministrativeEvaluation
 * @package App
 */
class AdministrativeEvaluation extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['session_id', 'user_id', 'attendance', 'punctuality', 'remarks', 'total'];
    /**
     * @var string
     */
    protected $table = 'administrative_evaluation';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
