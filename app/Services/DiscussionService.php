<?php

namespace App\Services;

use App\Classes\ApiResponseClass;
use App\Events\DiscussionCreatedEvent;
use App\Models\Course;
use App\Models\Discussion;

class DiscussionService
{
    public function listByCourse(object $user, $idCourse)
    {
        $course = Course::findOrFail($idCourse);

        $lecturer = $course->lecturer_id;
        $students = $user->courseEnrolled()->where('course_id', $idCourse)->exists();

        if ($lecturer === $user->id || $students) {
            $discussion = Discussion::where('course_id', $idCourse)->with(['replies', 'replies.user'])->get();

            return ApiResponseClass::successResponse($discussion, 'Success');
        } else {
            return ApiResponseClass::errorResponse('Kamu tidak memiliki izin untuk melakukan aksi ini.', 403);
        }
    }

    public function create(array $data, object $user)
    {
        $course = Course::findOrFail($data['course_id']);

        $lecturer = $course->lecturer_id;
        $students = $user->courseEnrolled()->where('course_id', $data['course_id'])->exists();

        if ($lecturer === $user->id || $students) {
            $discussion = Discussion::create([
                'course_id' => $data['course_id'],
                'user_id' => $user->id,
                'content' => $data['content']
            ]);

            broadcast(new DiscussionCreatedEvent($discussion))->toOthers();

            return ApiResponseClass::successResponse($discussion, 'Success');
        } else {
            return ApiResponseClass::errorResponse('Kamu tidak memiliki izin untuk melakukan aksi ini.', 403);
        }
    }
}
