<?php

namespace App\Services;

use App\Classes\ApiResponseClass;
use App\Mail\AssignmentCreatedMail;
use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Support\Facades\Mail;

class AssignmentService
{
    public function list(object $user, $courseId)
    {
        $course = Course::findOrFail($courseId);

        if ($course->lecturer_id === $user->id) {
            $assignment = Assignment::where('course_id', $courseId)->with(['submissions', 'submissions.student'])->get();

            return ApiResponseClass::successResponse($assignment, 'Success');
        } else {
            return ApiResponseClass::errorResponse('Kamu tidak memiliki izin untuk melakukan aksi ini.', 403);
        }
    }

    public function create(array $data, object $user)
    {
        $course = Course::findOrFail($data['course_id']);

        if ($course->lecturer_id === $user->id) {
            $assignment = Assignment::create($data);
            $assignment->load('course');

            $students = $course->students()->where('role', 'M')->get();

            Mail::to($students->pluck('email'))->send(new AssignmentCreatedMail($assignment));

            return ApiResponseClass::successResponse($assignment, 'Success');
        } else {
            return ApiResponseClass::errorResponse('Kamu tidak memiliki izin untuk melakukan aksi ini.', 403);
        }
    }
}
