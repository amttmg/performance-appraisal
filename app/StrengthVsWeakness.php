<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StrengthVsWeakness
 * @package App
 */
class StrengthVsWeakness extends Model
{
    /**
     * @var string
     */
    protected $table = 'strength_vs_weakness';

    /**
     * @var array
     */
    protected $fillable = ['strength', 'weakness', 'training_required', 'feedback'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function appraise()
    {
        return $this->belongsTo(Appraise::class);
    }
}
