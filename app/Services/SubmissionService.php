<?php

namespace App\Services;

use App\Classes\ApiResponseClass;
use App\Mail\SubmissionCreatedMail;
use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SubmissionService
{
    public function submit(array $data, object $user)
    {
        $assignment = Assignment::findOrFail($data['assignment_id']);

        $enrollUser = $user->courseEnrolled()->where('course_id', $assignment->course_id)->exists();

        if (!$enrollUser) {
            return ApiResponseClass::errorResponse('Anda tidak terdaftar di kelas ini.', 422);
        }

        $file = $data['file'];

        $path = $file->store('submissions');

        $submission = Submission::create([
            'assignment_id' => $data['assignment_id'],
            'student_id' => $user->id,
            'file_path' => $path
        ]);
        $submission->load(['student', 'assignment', 'assignment.course', 'assignment.course.lecturer']);

        $lecturer = $submission->assignment->course->lecturer->email;

        Mail::to($lecturer)->send(new SubmissionCreatedMail($submission));

        return $submission;
    }

    public function download(object $user, int $submissionId)
    {
        $submission = Submission::findOrFail($submissionId);

        if ($submission->assignment->course->lecturer_id === $user->id) {
            return Storage::download($submission->file_path);
        } else {
            return ApiResponseClass::errorResponse('Kamu tidak memiliki izin untuk melakukan aksi ini.', 403);
        }
    }

    public function grade(object $user, int $score, int $submissionId)
    {
        $submission = Submission::findOrFail($submissionId);

        if ($submission->assignment->course->lecturer_id === $user->id) {
            $submission->update([
                'score' => $score
            ]);

            return ApiResponseClass::successResponse($submission->score, 'Success');
        } else {
            return ApiResponseClass::errorResponse('Kamu tidak memiliki izin untuk melakukan aksi ini.', 403);
        }
    }
}
