<?php

use App\Models\Course;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('course.{courseId}', function ($user, $courseId) {
    $course = Course::find($courseId);

    if (!$course) return false;

    return $course->students()->where('user_id', $user->id)->exists() || $course->lecturer_id === $user->id;
});
