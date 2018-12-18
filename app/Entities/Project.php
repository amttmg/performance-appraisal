<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 * @package App\Entities
 */
class Project extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        "project_code",
        "planned_vs_spent_hours",
        "planned_vs_spent_beta_release",
        "project_quality",
        "project_complexity",
        "bug_vs_planned",
        "code_quality",
        "total_score",
        "is_completed",
        "department",
    ];

    /**
     * @param $value
     * @return string
     */
    public function getIsCompletedAttribute($value)
    {
        return $value ? 'Yes' : 'No';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
