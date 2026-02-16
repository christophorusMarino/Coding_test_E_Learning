<?php

namespace App\Services;

use App\Classes\ApiResponseClass;
use App\Models\Course;

class CourseService
{
    public function getData()
    {
        return Course::get();
    }

    public function create(array $data, int $lecturerId)
    {
        return Course::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'lecturer_id' => $lecturerId
        ]);
    }

    public function update(array $data, int $id, object $user)
    {
        $course = Course::findOrFail($id);

        if ($course->lecturer_id === $user->id) {
            $course->update($data);
            return ApiResponseClass::successResponse($course, 'Success');
        } else {
            return ApiResponseClass::errorResponse('Kamu tidak memiliki izin untuk melakukan aksi ini.', 403);
        }
    }

    public function delete(int $id, object $user)
    {
        $course = Course::findOrFail($id);

        if ($course->lecturer_id === $user->id) {
            $course->delete();
            return ApiResponseClass::successResponse($course, 'Success');
        } else {
            return ApiResponseClass::errorResponse('Kamu tidak memiliki izin untuk melakukan aksi ini.', 403);
        }
    }
}
