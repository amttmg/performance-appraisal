<?php

namespace App\Http\Controllers\Api;

use App\Services\QuestionService;
use App\Services\TechnologyService;
use Illuminate\Http\Request;
use function Psy\debug;

/**
 * Class QuestionController
 * @package App\Http\Controllers\Api
 */
class QuestionController extends ApiController
{
    /**
     * @var QuestionService
     */
    private $questionService;
    /**
     * @var TechnologyService
     */
    private $technologyService;

    /**
     * QuestionController constructor.
     * @param QuestionService   $questionService
     * @param TechnologyService $technologyService
     */
    public function __construct(
        QuestionService $questionService,
        TechnologyService $technologyService
    ) {
        $this->questionService   = $questionService;
        $this->technologyService = $technologyService;
    }

    /**
     * Get all questions
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
        $questions       = $this->questionService->all();
        $technologyCount = $this->technologyService->all()->count();
        $questions->map(function ($technology) use ($technologyCount) {
            return $technology->count = $technologyCount;
        });

        return response()->json($questions);
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Exception
     */
    public function store(Request $request)
    {
        return $this->questionService->store(($request->only('question', 'group_id', 'technologies')));
    }

    /**
     * @return mixed|\Symfony\Component\HttpFoundation\ParameterBag
     */
    public function getAllQuestionGroup()
    {
        $questionGroups = $this->questionService->getAllQuestionGroup();

        return response()->json($questionGroups);
    }

    /**
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function update(Request $request, $id)
    {
        $question = $this->questionService->update($request->only('question', 'group_id'), $id);
        $question->technologies()->sync($request->get('technologies'));

        return $this->responseSuccessUpdate();
    }

    /**
     * get all technologies
     *
     * @return mixed|\Symfony\Component\HttpFoundation\ParameterBag
     */
    public function getAllQuestionTechnology()
    {
        return response()->json($this->technologyService->all());
    }

    public function destroy($id)
    {
        $this->questionService->destroy($id);

        return $this->responseSuccessDelete();
    }
}
