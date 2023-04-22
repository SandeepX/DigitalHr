<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AppHelper;
use App\Requests\Task\TaskCommentRequest;
use App\Resources\Comment\CommentWithReplyResource;
use App\Resources\Comment\ReplyResource;
use App\Services\Task\TaskCommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Exception;

class TaskCommentApiController
{
    public TaskCommentService $commentService;

    public function __construct(TaskCommentService $commentService)
    {
        $this->commentService = $commentService;
    }


    public function saveComment(TaskCommentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            if (is_null($validatedData['comment_id'])) {
                $data = $this->commentService->storeTaskCommentDetail($validatedData);
                $detail = new CommentWithReplyResource($data);
            } else {
                $data = $this->commentService->storeCommentReply($validatedData);
                $detail = new ReplyResource($data);
            }
            DB::commit();
            return AppHelper::sendSuccessResponse('Comment Added Successfully', $detail);
        } catch (Exception $exception) {
            DB::rollBack();
            return AppHelper::sendErrorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function deleteComment($commentId): JsonResponse
    {
        try {
            DB::beginTransaction();
                $this->commentService->deleteTaskComment($commentId);
            DB::commit();
            return AppHelper::sendSuccessResponse('Comment Deleted Successfully');
        } catch (Exception $exception) {
            DB::rollBack();
            return AppHelper::sendErrorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    public function deleteReply($replyId): JsonResponse
    {
        try {
            DB::beginTransaction();
            $this->commentService->deleteReply($replyId);
            DB::commit();
            return AppHelper::sendSuccessResponse('Comment Reply Deleted Successfully');
        } catch (Exception $exception) {
            DB::rollBack();
            return AppHelper::sendErrorResponse($exception->getMessage(), $exception->getCode());
        }
    }

}
