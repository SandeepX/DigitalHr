<?php

namespace App\Repositories;

use App\Models\Tada;
use App\Models\TadaAttachment;
use App\Traits\ImageService;
use Exception;

class TadaAttachmentRepository
{
    use ImageService;

    public function findTadaAttachmentById($id, $with = [], $select = ['*'])
    {
        return TadaAttachment::select($select)->with($with)
            ->where('id', $id)
            ->first();
    }

    public function delete($attachmentDetail)
    {
        return $attachmentDetail->delete();
    }

    public function prepareAttachmentData($validatedAttachmentDetail): array
    {
        try {
            $attachments = [];
            foreach ($validatedAttachmentDetail as $key => $value) {
                $attachments[$key]['attachment'] = $this->storeImage($value, TadaAttachment::ATTACHMENT_UPLOAD_PATH);
            }
            return $attachments;
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function saveTadaAttachment(Tada $tadaDetail, $attachmentDetail)
    {
        return $tadaDetail->attachments()->createMany($attachmentDetail);
    }

    public function removeImageFromPublic($attachment)
    {
        $this->removeImage(TadaAttachment::ATTACHMENT_UPLOAD_PATH, $attachment);
    }

    public function findAttachmentDetailByAttachmentIdAndEmployeeId($employeeId,$attachmentId,$select,$with)
    {
        return TadaAttachment::select($select)->with($with)
            ->whereHas('tada',function($query) use ($employeeId) {
                $query->where('employee_id',$employeeId);
            })
            ->where('id',$attachmentId)
            ->first();
    }


}
