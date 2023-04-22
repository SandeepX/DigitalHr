<?php

namespace App\Resources\Attachment;

use App\Models\Attachment;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    public function toArray($request)
    {
        $data = [
            'attachment_url' => asset(Attachment::UPLOAD_PATH.$this->attachment),
            'extension' => $this->attachment_extension
        ];
        $data['type'] = (!in_array($this->attachment_extension,['pdf','doc','docx','ppt','txt','xls','zip'])) ? 'image' : 'document';
        return $data;
    }
}
