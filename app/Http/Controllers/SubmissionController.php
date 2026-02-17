<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\FormRequestSubmission;
use App\Services\SubmissionService;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function __construct(
        protected SubmissionService $submissionService
    ) {}

    public function uploadData(FormRequestSubmission $request)
    {
        $user = $request->user();
        $submission = $this->submissionService->submit($request->validated(), $user);

        return $submission;
    }

    public function downloadData(Request $request, $id)
    {
        $user = $request->user();
        $data = $this->submissionService->download($user, $id);
        return $data;
    }

    public function gradeSubmission(Request $request, $id)
    {
        $user = $request->user();
        $validated = $request->validate([
            'score' => 'required|integer|min:0|max:100'
        ]);

        $score = $this->submissionService->grade($user, $validated['score'], $id);
        return $score;
    }
}
