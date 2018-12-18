<?php

namespace App\Services;

use App\Answer;
use App\AppraisalType;
use App\Question;
use App\QuestionGroup;
use App\User;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Mixins\DownloadCollection;


/**
 * Class QuestionService
 * @package App\Services
 */
class QuestionService extends BaseService
{
    /**
     * @var Question
     */
    protected $model;
    /**
     * @var QuestionGroup
     */
    private $questionGroup;
    /**
     * @var DatabaseManager
     */
    private $databaseManager;
    /**
     * @var AppraisalType
     */
    private $appraisalType;
    /**
     * @var Excel
     */
    private $excel;
    /**
     * @var Answer
     */
    private $answer;
    /**
     * @var User
     */
    private $user;

    /**
     * QuestionService constructor.
     * @param Question        $question
     * @param QuestionGroup   $questionGroup
     * @param DatabaseManager $databaseManager
     * @param AppraisalType   $appraisalType
     * @param User            $user
     * @param Excel           $excel
     * @param Answer          $answer
     */
    public function __construct(
        Question $question,
        QuestionGroup $questionGroup,
        DatabaseManager $databaseManager,
        AppraisalType $appraisalType,
        User $user,
        Excel $excel,
        Answer $answer
    ) {
        $this->model           = $question;
        $this->questionGroup   = $questionGroup;
        $this->databaseManager = $databaseManager;
        $this->appraisalType   = $appraisalType;
        $this->excel           = $excel;
        $this->answer          = $answer;
        $this->user            = $user;
    }

    /**
     * @return Question[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Query\Builder[]|\Illuminate\Support\Collection|mixed
     */
    public function all()
    {
        return $this->model->with(['technologies', 'group.parent'])->latest()->get();
    }

    /**
     * Get all questions groups
     *
     * @return QuestionGroup[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllQuestionGroup()
    {
        return $this->questionGroup->orderBy('title')->whereNull('parent_id')->with([
            'children' => function ($qyery) {
                $qyery->orderBy('title');
            },
        ])->get();
    }

    /**
     * @param $storeData
     * @throws \Exception
     */
    public function store($storeData)
    {
        try {
            $this->databaseManager->beginTransaction();
            $question = $this->model->create($storeData);
            $question->technologies()->sync($storeData['technologies']);
            $this->databaseManager->commit();
        } catch (\Exception $exception) {
            $this->databaseManager->rollBack();
            throw $exception;
        }
    }

    /**
     * Get Report
     *
     * @return mixed
     */
    public function getReport()
    {

        $questionGroups = $this->questionGroup
            ->with('questions')
            ->whereHas('questions')
            ->orderBy('title', 'asc')->get();

        $questionHeaders                  = $this->model->get()->pluck('question', 'id')->toArray();
        $subHeaders                       = $this->appraisalType->all()->pluck('title', 'id')->toArray();
        $reports['headers']['groups']     = $questionGroups;
        $reports['headers']['questions']  = $questionHeaders;
        $reports['headers']['subHeaders'] = $subHeaders;
        $reports['body']                  = $this->user->whereHas('myAppraisal')->get();

        return $reports;

    }

    /**
     * Get Report
     *
     * @return mixed
     */
    public function getAllReport()
    {
        return $this->answer
            ->join('appraise', 'appraise.id', '=', 'answers.appraise_id')
            ->join('users', 'users.id', '=', 'appraise.appraisal_of')
            ->join('appraisal_types', 'appraisal_types.id', '=', 'appraise.type_id')
            ->join('questions', 'questions.id', '=', 'answers.question_id')
            ->join('question_groups', 'question_groups.id', '=', 'questions.group_id')
            ->select('users.id as UserID', 'users.email as Email', 'users.name as Employee', 'appraisal_types.title as Type', 'question_groups.title as Q.Group', 'questions.id as Q.Id', 'questions.question', 'answers.rating')->get();
    }
}