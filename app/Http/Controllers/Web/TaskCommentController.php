<?php

namespace App\Http\Controllers\Web;

use App\Helpers\AppHelper;
use App\Helpers\SMPush\SMPushHelper;
use App\Http\Controllers\Controller;
use App\Requests\Task\TaskCommentRequest;
use App\Resources\Comment\TaskCommentResource;
use App\Services\Notification\NotificationService;
use App\Services\Task\TaskCommentService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TaskCommentController extends Controller
{
    public TaskCommentService $commentService;
    private NotificationService $notificationService;

    private $view = 'admin.task.';

    public function __construct(TaskCommentService $commentService,NotificationService $notificationService)
    {
        $this->commentService = $commentService;
        $this->notificationService = $notificationService;
    }


    public function saveCommentDetail(TaskCommentRequest $request): JsonResponse
    {
        $this->authorize('create_comment');
        try {
            DB::beginTransaction();
            $validatedData = $request->validated();
            if (is_null($validatedData['comment_id'])) {
                $data = $this->commentService->storeTaskCommentDetail($validatedData);
                $commentType = 'comment';
                $taskName = $data?->task?->name;
            } else {
                $data = $this->commentService->storeCommentReply($validatedData);
                $commentType = 'comment reply';
                $taskName = $data?->comment?->task?->name;
            }
            DB::commit();
            if (isset($validatedData['mentioned'])) {
                $notificationData['title'] = 'Comment Notification';
                $notificationData['type'] = 'comment';
                $notificationData['user_id'] = $validatedData['mentioned'];
                $notificationData['description'] = 'You are mentioned in task ' . ($taskName) . ' ' . $commentType;
                $notificationData['notification_for_id'] = $validatedData['task_id'];
                $notification = $this->notificationService->store($notificationData);
                if($notification){
                    $this->sendNotificationToMentionedMemberInComment(
                        $notification->title,
                        $notification->description,
                        $notificationData['user_id'],
                        $data->task_id);
                }
            }
            return AppHelper::sendSuccessResponse('Successfully Created Data', new TaskCommentResource($data));
        } catch (Exception $exception) {
            DB::rollBack();
            return AppHelper::sendErrorResponse($exception->getMessage(), $exception->getCode());
        }
    }

    private function sendNotificationToMentionedMemberInComment($title,$message, $userIds, $taskId)
    {
        SMPushHelper::sendProjectManagementNotification($title, $message, $userIds, $taskId);
    }

    public function deleteComment($commentId): JsonResponse
    {
        $this->authorize('delete_comment');
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
        $this->authorize('delete_comment');
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
