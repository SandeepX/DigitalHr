<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AppHelper;
use App\Helpers\AttendanceHelper;
use App\Helpers\SMPush\SMPushHelper;
use App\Repositories\SupportRepository;
use App\Requests\Support\SupportStoreRequest;
use App\Resources\Support\SupportResource;
use Exception;
use Illuminate\Http\JsonResponse;

class SupportApiController
{
    public SupportRepository $supportRepo;

    public function __construct(SupportRepository $supportRepo)
    {
        $this->supportRepo = $supportRepo;
    }

    public function store(SupportStoreRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();
            $detail = $this->supportRepo->store($validatedData);
//            if($detail){
//                $this->supportNotification(
//                    'Support Notification',
//                    ucfirst($detail->createdBy->name) . 'has requested for support '.ucfirst($detail->title)
//                );
//            }
            return AppHelper::sendSuccessResponse(
                'Query Submitted Successfully',
                new SupportResource($detail)
            );
        } catch (Exception $e) {
            return AppHelper::sendErrorResponse($e->getMessage(), $e->getCode());
        }
    }

    private function supportNotification($title, $message)
    {
        SMPushHelper::sendNotificationToAdmin($title, $message);
    }

}
