<?php

namespace App\Services;

use App\Classes\ApiResponseClass;
use App\Models\Course;
use App\Models\Material;
use Illuminate\Support\Facades\Storage;

class MaterialService
{
    public function upload(array $data, object $user)
    {
        $course = Course::findOrFail($data['course_id']);

        if ($course->lecturer_id === $user->id) {
            $file = $data['file'];

            $path = $file->store('materials');

            $materials = Material::create([
                'course_id' => $course->id,
                'title'     => $data['title'],
                'file_path' => $path,
            ]);

            return ApiResponseClass::successResponse($materials, 'Success');
        } else {
            return ApiResponseClass::errorResponse('Kamu tidak memiliki izin untuk melakukan aksi ini.', 403);
        }
    }

    public function download(object $user, int $id)
    {
        $material = Material::findOrFail($id);

        $enrollUser = $user->courseEnrolled()->where('course_id', $id)->exists();
        if (!$enrollUser) {
            return ApiResponseClass::errorResponse('Anda tidak terdaftar di kelas ini.', 422);
        }

        return Storage::download($material->file_path);
    }
}
