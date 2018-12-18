<?php

namespace App\Services\Excel;


use App\Services\QuestionService;
use App\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExcel implements FromView
{
    Use Exportable;
    /**
     * @var User
     */
    private $user;
    /**
     * @var QuestionService
     */
    private $questionService;

    /**
     * ReportExcel constructor.
     * @param User            $user
     * @param QuestionService $questionService
     */
    public function __construct(User $user, QuestionService $questionService)
    {
        $this->user            = $user;
        $this->questionService = $questionService;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        $reports = $this->questionService->getReport();

        return view('exports.reports', compact('reports'));
    }
}