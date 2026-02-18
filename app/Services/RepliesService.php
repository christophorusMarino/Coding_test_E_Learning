<?php

namespace App\Services;

use App\Classes\ApiResponseClass;
use App\Events\RepliesCreatedEvent;
use App\Models\Discussion;
use App\Models\Replies;

class RepliesService
{
    public function create(array $data, object $user, int $id)
    {
        $discussion = Discussion::findOrFail($id);

        $lecturer = $discussion->course->lecturer_id;
        $students = $user->courseEnrolled()->where('course_id', $discussion->course->id)->exists();

        if ($lecturer === $user->id || $students) {
            $replies = Replies::create([
                'discussion_id' => $id,
                'user_id' => $user->id,
                'content' => $data['content']
            ]);

            broadcast(new RepliesCreatedEvent($replies))->toOthers();

            return ApiResponseClass::successResponse($replies, 'Success');
        } else {
            return ApiResponseClass::errorResponse('Kamu tidak memiliki izin untuk melakukan aksi ini.', 403);
        }
    }
}
