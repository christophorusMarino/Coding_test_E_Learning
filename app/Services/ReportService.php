<?php

namespace App\Services;

use App\Classes\ApiResponseClass;
use App\Models\Assignment;
use App\Models\Course;
use App\Models\Submission;
use App\Models\User;

class ReportService
{
    public function courses(object $user)
    {
        $data = Course::query()
            ->select('id', 'name', 'description')
            ->withCount('students')
            ->where('lecturer_id', $user->id)
            ->get();

        return $data;
    }

    public function assignment(object $user)
    {
        $assignment = Assignment::query()
            ->select('id', 'title', 'course_id')
            ->withCount([
                'submissions as total_tugas',
                'submissions as dinilai' => function ($q) {
                    $q->whereNotNull('score');
                },
                'submissions as belum_dinilai' => function ($q) {
                    $q->whereNull('score');
                },
            ])
            ->withWhereHas('course', function ($query) use ($user) {
                $query->where('lecturer_id', $user->id);
            })
            ->get();

        return $assignment;
    }

    public function studentSubmission($id)
    {
        $student = User::findOrFail($id);

        if ($student->role === 'M') {
            $totalAssignments = Assignment::count();
            $submitted = Submission::where('student_id', $id)->count();

            $nilaiRataRata = Submission::where('student_id', $id)
                ->whereNotNull('score')
                ->avg('score');

            $response = [
                'name' => $student->name,
                'total_tugas' => $totalAssignments,
                'dikumpul' => $submitted,
                'avg_score' => round($nilaiRataRata, 2)
            ];

            return ApiResponseClass::successResponse($response, 'success');
        } else {
            return ApiResponseClass::errorResponse('Data Tidak Valid', 422);
        }
    }
}
