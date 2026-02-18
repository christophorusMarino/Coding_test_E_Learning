<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    public function reportCourse(Request $request)
    {
        $user = $request->user();
        $data = $this->reportService->courses($user);

        return ApiResponseClass::successResponse($data, 'Success');
    }

    public function reportAssignment(Request $request)
    {
        $user = $request->user();
        $data = $this->reportService->assignment($user);

        return ApiResponseClass::successResponse($data, 'Success');
    }

    public function studentReport($id)
    {
        $data = $this->reportService->studentSubmission($id);

        return $data;
    }
}
