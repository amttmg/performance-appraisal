<?php

namespace App;

use App\Entities\Project;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'role_id', 'technology_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function appraiseAssignedTo()
    {
        return $this->hasMany(Appraise::class, 'appraisal_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function myAppraisal()
    {
        return $this->hasMany(Appraise::class, 'appraisal_of');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function activeProjects()
    {
        return $this->belongsToMany(Project::class)
            ->join('sessions', function ($join) {
                $join->on('sessions.id', '=', 'project_user.session_id')
                    ->where('sessions.is_active', true);
            });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function administrativeEvaluations()
    {
        return $this->hasOne(AdministrativeEvaluation::class)
            ->join('sessions', function ($join) {
                $join->on('sessions.id', '=', 'administrative_evaluation.session_id')
                    ->where('sessions.is_active', true);
            });
    }

    /**
     * work evaluation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workEvaluations()
    {
        return $this->hasOne(WorkEvaluation::class)
            ->join('sessions', function ($join) {
                $join->on('sessions.id', '=', 'work_evaluation.session_id')
                    ->where('sessions.is_active', true);
            });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function technology()
    {
        return $this->belongsTo(Technology::class);
    }

    /**
     * Has one role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class)->withPivot('id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reports()
    {
        return $this->hasMany(FinalReport::class);
    }

    /**
     * work evaluation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function activeReport()
    {
        return $this->hasOne(FinalReport::class)
            ->select('final_reports.*')
            ->join('sessions', function ($join) {
                $join->on('sessions.id', '=', 'final_reports.session_id')
                    ->where('sessions.is_active', true);
            })->where('is_published', 1);
    }

}
