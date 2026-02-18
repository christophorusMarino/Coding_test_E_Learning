<?php

namespace App\Http\Controllers;

use App\Events\DiscussionCreatedEvent;
use App\Http\Requests\Discussion\FormRequestDiscussion;
use App\Services\DiscussionService;
use Illuminate\Http\Request;

class DiscussionController extends Controller
{
    public function __construct(
        protected DiscussionService $discussionService
    ) {}

    public function list(Request $request, $idCourse)
    {
        $user = $request->user();
        $discussion = $this->discussionService->listByCourse($user, $idCourse);

        return $discussion;
    }

    public function addData(FormRequestDiscussion $request)
    {
        $user = $request->user();
        $discussion = $this->discussionService->create($request->validated(), $user);

        return $discussion;
    }
}
