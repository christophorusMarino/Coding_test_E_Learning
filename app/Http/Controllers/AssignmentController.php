<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\FormRequestAssignment;
use App\Services\AssignmentService;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function __construct(
        protected AssignmentService $assignmentService
    ) {}
    
    public function list(Request $request, $courseId)
    {
        $user = $request->user();
        $assignment = $this->assignmentService->list($user, $courseId);

        return $assignment;
    }

    public function addData(FormRequestAssignment $request)
    {
        $user = $request->user();
        $assignment = $this->assignmentService->create($request->validated(), $user);

        return $assignment;
    }
}
