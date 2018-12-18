<?php

namespace App\Http\Controllers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;

/**
 * Class FinalReportController
 * @package App\Http\Controllers
 */
class FinalReportController extends Controller
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * FinalReportController constructor.
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * Display reports
     */
    public function myReport()
    {
        $user   = auth()->user();
        $report = $user->activeReport;
        if ($report) {
            $file = base_path('public/uploads/'.$report->report);
            if ($this->filesystem->exists($file)) {
                return response()->file($file);
            }
        }

        return redirect()->route('home');
    }
}
