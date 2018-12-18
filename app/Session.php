<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Session
 * @package App
 */
class Session extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['code', 'description', 'from', 'to', 'is_active'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appraises()
    {
        return $this->hasMany(Appraise::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workEvaluation()
    {
        return $this->hasMany(WorkEvaluation::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function administrativeEvaluation()
    {
        return $this->hasMany(AdministrativeEvaluation::class);
    }
}
