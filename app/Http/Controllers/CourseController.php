<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Http\Requests\Course\FormRequestCourse;
use App\Services\CourseService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct(
        protected CourseService $courseService
    ) {}

    public function list()
    {
        $courses = $this->courseService->getData();

        return ApiResponseClass::successResponse($courses, 'Success');
    }

    public function addData(FormRequestCourse $request)
    {
        $idUser = $request->user()->id;
        $course = $this->courseService->create($request->validated(), $idUser);

        return ApiResponseClass::successResponse($course, 'Success');
    }

    public function updateData(FormRequestCourse $request, $id)
    {
        $user = $request->user();
        $course = $this->courseService->update($request->validated(), $id, $user);

        return $course;
    }

    public function deleteData(Request $request, $id)
    {
        $user = $request->user();
        $course = $this->courseService->delete($id, $user);

        return $course;
    }
}
