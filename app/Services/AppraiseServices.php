<?php

namespace App\Services;

use App\AppraisalType;
use App\Appraise;
use App\Constants\AppraiseTypes;
use App\Constants\UserRole;
use App\QuestionGroup;
use App\Session;
use App\User;
use Illuminate\Support\Facades\DB;

/**
 * Class EmployeeServices
 * @package App\Services
 */
class AppraiseServices extends BaseService
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var Appraise
     */
    protected $model;

    /**
     * AppraiseServices constructor.
     * @param User     $user
     * @param Appraise $appraise
     */
    public function __construct(User $user, Appraise $appraise)
    {
        $this->user  = $user;
        $this->model = $appraise;
    }

    /**
     * @param $user
     * @return
     */
    public function getUsersAssignTo($user)
    {
        $userDetail = $user->appraiseAssignedTo()
            ->with([
                'appraisalSession',
                'type',
                'appraiseBy',
                'appraiseOf',
            ]);
        $role       = $user->role->title;
        if ($role != UserRole::DEVELOPER) {
            $userDetail->with(['appraiseOf.activeProjects', 'appraiseOf.administrativeEvaluations', 'appraiseOf.workEvaluations']);
        }

        return $userDetail->get();
    }

    /**
     * get Projects of user by appraise id
     *
     * @param $appraiseId
     * @return mixed
     */
    public function getProjects($appraiseId)
    {
        return $this->model->whereHas('appraisalSession', function ($query) {
            $query->where('is_active', 1);
        })->with('appraiseOf.projects')->find($appraiseId);
    }

    /**
     * @param $appraiseId
     * @return
     */
    public function getQuestions($appraiseId)
    {
        $appraise = $this->model->find($appraiseId);
        $user     = $appraise->appraiseOf;
        $ids      = [];
        if ($user) {
            $technology = $user->technology;
            if ($technology) {
                $questions = $technology->questions;
                if ($questions) {
                    foreach ($questions as $question) {
                        array_push($ids, $question->id);
                    }
                }
            }
        }

        return QuestionGroup::whereNull('parent_id')
            ->whereHas('questions', function ($query) use ($ids) {
                $query->whereIn('questions.id', $ids);
            })
            ->orWhereHas('children.questions', function ($query) use ($ids) {
                $query->whereIn('questions.id', $ids);
            })
            ->with(['children'           => function ($query) use ($ids) {
                $query->whereHas('questions', function ($query) use ($ids) {
                    $query->whereIn('id', $ids);
                });
            },
                    'children.questions' => function ($query) use ($ids, $appraiseId) {
                        $query
                            ->select(['questions.id', 'group_id', 'question', 'answers.rating as answer', 'answers.feedback'])
                            ->leftJoin('answers', function ($join) use ($appraiseId) {
                                $join->on('questions.id', '=', 'answers.question_id')->where('appraise_id', $appraiseId);
                            })
                            ->whereIn('questions.id', $ids);
                    },
                    'questions'          => function ($query) use ($ids, $appraiseId) {
                        $query
                            ->select(['questions.id', 'group_id', 'question', 'answers.rating as answer', 'answers.feedback'])
                            ->leftJoin('answers', function ($join) use ($appraiseId) {
                                $join->on('questions.id', '=', 'answers.question_id')->where('appraise_id', $appraiseId);
                            })
                            ->whereIn('questions.id', $ids);
                    }])->get();
    }

    public function getStrengthVsWeakness($appraiseId)
    {
        $appraise = $this->model->find($appraiseId);

        return $appraise->strengthVsWeakness ?? [
                'strength'          => '',
                'weakness'          => '',
                'feedback'          => '',
                'training_required' => '',
            ];
    }

    /**
     * @param $storeData
     * @return \Exception
     */
    public function store($storeData)
    {
        try {
            DB::transaction(function () use ($storeData) {
                $appraise           = $storeData['appraise'];
                $answers            = $storeData['answers'];
                $strengthVsWeakness = $storeData['strengthVsWeakness'];
                $isCompeted         = $appraise['is_completed'];
                $appraise           = $this->find($appraise['id']);
                $appraise->update(['is_completed' => $isCompeted]);
                if ($appraise && $answers) {
                    if ($appraise) {
                        foreach ($answers as $answer) {
                            $appraise->answers()->updateOrCreate(
                                ['appraise_id' => $appraise->id, 'question_id' => $answer['id']],
                                [
                                    'question_id' => $answer['id'],
                                    'rating'      => $answer['answer'],
                                    'feedback'    => $answer['feedback'] ?? 'NA',
                                ]
                            );
                        }
                    }
                }
                $strengthVsWeaknessData = [
                    'strength'          => $strengthVsWeakness['strength'],
                    'weakness'          => $strengthVsWeakness['weakness'],
                    'feedback'          => $strengthVsWeakness['feedback'],
                    'training_required' => $strengthVsWeakness['training_required'],
                ];
                if ($appraise->strengthVsWeakness) {
                    $appraise->strengthVsWeakness()->update($strengthVsWeaknessData);
                } else {
                    $appraise->strengthVsWeakness()->create($strengthVsWeaknessData);
                }
            });
        } catch (\Exception $exception) {
            return $exception;
        }
    }

    /**
     * @param $storeData
     * @return bool
     */
    public function addAppraise($storeData)
    {
        $session = Session::where('is_active', 1)->firstOrFail();
        if ($storeData['peer']) {
            $this->storeAppraise($session, $storeData['employee']['value'], $storeData['peer']['value'], AppraiseTypes::PEER_ID);
        }

        return true;
    }

    public function getAppraiseBySession($sessionId, $technologyId)
    {
        $appraiseUsers = $this->model
            ->select('appraisal_of');
        if ($technologyId != 0) {
            $appraiseUsers
                ->join('users', 'users.id', '=', 'appraise.appraisal_of')
                ->where('users.technology_id', $technologyId);
        }
        $appraiseUsers = $appraiseUsers
            ->where('session_id', $sessionId)
            ->groupBy('appraisal_of')
            ->get();
        $appraiseUsers->map(function ($user) use ($sessionId) {
            $user->employee   = User::find($user->appraisal_of);
            $user->appraiseBy = $this->model->where(['session_id' => $sessionId, 'appraisal_of' => $user->appraisal_of])->with(['appraiseBy', 'type'])->get();
        });

        return $appraiseUsers;
    }

    public function storeSupervisor($storeData)
    {
        $supervisor = $storeData['supervisor'];
        $employees  = $storeData['employees'];
        DB::transaction(function () use ($supervisor, $employees) {
            $session = Session::where('is_active', 1)->firstOrFail();
            if ($supervisor && $employees) {
                foreach ($employees as $employee) {
                    $this->storeAppraise($session, $employee, $supervisor['value'], AppraiseTypes::SUPERVISOR_ID);
                }
            }
        });

        return true;

    }

    private function storeAppraise($session, $appraiseOf, $appraiseBy, $typeId)
    {
        $session->appraises()->updateOrCreate(
            [
                'appraisal_of' => $appraiseOf,
                'appraisal_by' => $appraiseBy,
            ],
            [
                'appraisal_of' => $appraiseOf,
                'appraisal_by' => $appraiseBy,
                'type_id'      => $typeId,
            ]
        );
        if (!$session->appraises()->where(['appraisal_of' => $appraiseOf, 'appraisal_by' => $appraiseBy, 'type_id' => AppraiseTypes::SELF_ID])->exists()) {
            $this->storeAppraise($session, $appraiseOf, $appraiseOf, AppraiseTypes::SELF_ID);
        }
    }
}
