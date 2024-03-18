<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $teacher_id = $this->teacher_id;

        $teacher = User::whereHas(
            'roles', function($q) use($teacher_id){
                $q->where('name', 'Teacher');
            }
        )->find($teacher_id);

        return [
            'id' => $this->id,
            'subject_code' => $this->subject_code,
            'name' => $this->name,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'day' => $this->day,
            'prereq_subject_code' => $this->prereq_subject_code,
            'prereq_name' => $this->prereq_name,
            'room_no' => $this->room_no,
            'units' => $this->units,
            'detail' => $this->detail,
            'teacher' => $teacher,
            'is_prereq' => $this->is_prereq,
        ];
    }
}
