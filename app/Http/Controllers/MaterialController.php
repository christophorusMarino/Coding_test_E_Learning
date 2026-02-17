<?php

namespace App\Http\Controllers;

use App\Http\Requests\Course\FormRequestMaterial;
use App\Services\MaterialService;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function __construct(
        protected MaterialService $materialService
    ) {}

    public function uploadData(FormRequestMaterial $request)
    {
        $user = $request->user();
        $material = $this->materialService->upload($request->validated(), $user);

        return $material;
    }

    public function downloadData(Request $request, $id)
    {
        $user = $request->user();
        
        return $this->materialService->download($user, $id);
    }
}
