<?php

namespace App\Http\Controllers\Api;

use App\AdministrativeEvaluation;
use App\FinalReport;
use App\Http\Requests\AppraiseRequest;
use App\Services\AppraiseServices;
use App\Services\Excel\ReportExcel;
use App\Services\QuestionService;
use App\Session;
use App\User;
use App\WorkEvaluation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Excel;

/**
 * Class ApiEvaluationFormController
 * @package App\Http\Controllers\Api
 */
class AppraiseController extends ApiController
{
    /**
     * @var AppraiseServices
     */
    protected $appraiseServices;
    /**
     * @var QuestionService
     */
    private $questionService;
    /**
     * @var Excel
     */
    private $excel;
    /**
     * @var ReportExcel
     */
    private $reportExcel;

    /**
     * EvaluationFormController constructor.
     * @param AppraiseServices $appraiseServices
     * @param QuestionService  $questionService
     * @param Excel            $excel
     * @param ReportExcel      $reportExcel
     */
    public function __construct(
        AppraiseServices $appraiseServices,
        QuestionService $questionService,
        Excel $excel,
        ReportExcel $reportExcel
    ) {
        $this->appraiseServices = $appraiseServices;
        $this->questionService  = $questionService;
        $this->excel            = $excel;
        $this->reportExcel      = $reportExcel;
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $sessionId    = request('session_id');
        $technologyId = request('technology_id');
        if (!$sessionId) {
            $session   = Session::where('is_active', 1)->firstOrFail();
            $sessionId = $session->id;
        }
        $appraises = $this->appraiseServices->getAppraiseBySession($sessionId, $technologyId);

        return $this->responseWithData($appraises);
    }

    /**
     *
     */
    public function getAppraiseAssignToMe()
    {
        $currentUser    = auth()->user();
        $data['data']   = $this->appraiseServices->getUsersAssignTo($currentUser);
        $data['report'] = $currentUser->activeReport;

        return $this->responseWithData($data);
    }

    /**
     * @param $appraiseId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getQuestions($appraiseId)
    {
        return $this->responseWithData(
            [
                'questions'          => $this->appraiseServices->getQuestions($appraiseId),
                'strengthVsWeakness' => $this->appraiseServices->getStrengthVsWeakness($appraiseId),
            ]
        );
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->appraiseServices->store($request->only('answers', 'appraise', 'strengthVsWeakness'));
    }

    /**
     * Get reports
     *
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        $reports  = $this->questionService->getReport();
        $contents = View::make('exports.reports', compact('reports'));
        $response = Response::make($contents, 200);
        $response->header('Content-type', 'application/excel');
        $response->header('Content-Disposition', 'attachment; filename=report-'.Carbon::now()->format('Y-m-d H:i:s').'.xls');

        return $response;
    }

    /**
     * Get reports
     *
     * @return \Illuminate\Http\Response
     */
    public function reportAll()
    {
        $reports  = $this->questionService->getAllReport();
        $contents = View::make('exports.reportsAll', compact('reports'));
        $response = Response::make($contents, 200);
        $response->header('Content-type', 'application/excel');
        $response->header('Content-Disposition', 'attachment; filename=report-'.Carbon::now()->format('Y-m-d H:i:s').'.xls');

        return $response;
    }

    /**
     * @param AppraiseRequest $request
     */
    public function addAppraise(AppraiseRequest $request)
    {
        $this->appraiseServices->addAppraise($request->only('peer', 'self', 'employee'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function storeSupervisor(Request $request)
    {
        $this->appraiseServices->storeSupervisor($request->only('supervisor', 'employees'));

        return $this->responseSuccessCreate();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id)
    {
        $this->appraiseServices->destroy($id);

        return $this->responseSuccessDelete();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function reset($id)
    {
        $appraise               = $this->appraiseServices->find($id);
        $appraise->is_completed = null;
        $appraise->save();

        return $this->responseSuccessUpdate();
    }

    /**
     * @param Request $request
     */
    public function importWorkEvaluation(Request $request)
    {
        $importedFileCsv = $request->file('importedFile');
        $workEvaluations = csvToArray($importedFileCsv);
        $session         = Session::where('is_active', 1)->firstOrFail();
        foreach ($workEvaluations as $evaluation) {
            $user = User::where('email', $evaluation['email'])->firstOrFail();
            WorkEvaluation::updateOrCreate(
                [
                    'session_id' => $session->id,
                    'user_id'    => $user->id,
                ],
                [
                    'session_id'   => $session->id,
                    'user_id'      => $user->id,
                    'efficiency'   => $evaluation['efficiency'],
                    'productivity' => $evaluation['productivity'],
                    'total'        => $evaluation['total'],
                ]
            );
        }
    }

    /**
     * @param Request $request
     */
    public function importAdministrativeEvaluation(Request $request)
    {
        $importedFileCsv          = $request->file('importedFile');
        $administrativeEvaluation = csvToArray($importedFileCsv);

        $session = Session::where('is_active', 1)->firstOrFail();
        foreach ($administrativeEvaluation as $evaluation) {
            $user = User::where('email', $evaluation['email'])->firstOrFail();
            AdministrativeEvaluation::updateOrCreate(
                [
                    'session_id' => $session->id,
                    'user_id'    => $user->id,
                ],
                [
                    'session_id'  => $session->id,
                    'user_id'     => $user->id,
                    'attendance'  => $evaluation['attendance'],
                    'punctuality' => $evaluation['punctuality'],
                    'total'       => $evaluation['total'],
                ]
            );
        }
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getEvaluations()
    {
        $session = Session::where('is_active', 1)->firstOrFail();

        return $this->responseWithData([
            'work'           => $session->workEvaluation()->with('user')->get(),
            'administrative' => $session->administrativeEvaluation()->with('user')->get(),
        ]);
    }

    public function reportUpload(Request $request)
    {
        $fileName = uniqid().'.pdf';
        $user     = User::findOrFail($request->get('id'));
        if ($request->file('file')->storeAs('uploads', $fileName)) {
            $session = Session::where('is_active', 1)->firstOrFail();
            $user->reports()->updateOrCreate(
                ['session_id' => $session->id],
                [
                    'session_id'   => $session->id,
                    'report'       => $fileName,
                    'is_published' => true,
                ]
            );

            return $this->responseSuccessUpdate();
        } else {
            return $this->response("Error", "error", 400);
        }
    }

    public function reportDelete($id)
    {
        $report  = FinalReport::findOrFail($id);
        $success = Storage::delete('uploads/'.$report->report);
        if ($success) {
            $report->delete();
        } else {
            return $this->response("Error", "error", 400);
        }

        return $this->responseSuccessUpdate();
    }
}
