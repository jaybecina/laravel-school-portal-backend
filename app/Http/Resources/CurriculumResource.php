<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurriculumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $courses_unique = $this->courses->unique();

        $coursesData = $courses_unique->map(function ($course) {
            $subjects = $course->subjects()->where('curriculum_id', $this->id)->where('course_id', $course->id)->get()->unique();

            return [
                'id' => $course->id,
                'course_code' => $course->course_code,
                'title' => $course->title,
                'desc' => $course->desc,
                'credits' => $course->credits,
                'subjects' => $subjects,
            ];
        });

        return [
            'id' => $this->id,
            'curriculum_code' => $this->curriculum_code,
            'name' => $this->name,
            'desc' => $this->desc,
            'credits' => $this->credits,
            'is_active' => $this->is_active,
            'courses' => $coursesData
        ];
    }
}
