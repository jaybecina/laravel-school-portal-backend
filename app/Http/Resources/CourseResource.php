<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $subjects_unique = $this->subjects->unique();

        return [
            'id' => $this->id,
            'course_code' => $this->course_code,
            'title' => $this->title,
            'desc' => $this->desc,
            'credits' => $this->credits,
            'subjects' => $subjects_unique,
        ];
    }
}
