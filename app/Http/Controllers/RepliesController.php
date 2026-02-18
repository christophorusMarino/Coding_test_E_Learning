<?php

namespace App\Http\Controllers;

use App\Http\Requests\Discussion\FormRequestReplies;
use App\Services\RepliesService;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct(
        protected RepliesService $repliesService
    ){}

    public function addData(FormRequestReplies $request, $id)
    {
        $user = $request->user();
        $replies = $this->repliesService->create($request->validated(), $user, $id);

        return $replies;
    }
}
