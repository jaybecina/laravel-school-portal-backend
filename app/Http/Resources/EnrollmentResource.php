<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Enrollment;
use App\Models\Curriculum;
use App\Models\Course;
use Illuminate\Support\Arr;

class EnrollmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $curriculum_unique = $this->curricula->unique();

        $curriculum_id = $curriculum_unique[0]->id;

        $coursesPivot = $curriculum_unique->map(function ($course) use($curriculum_id) {
            $courses = $course->enrolledCourses()->where('enrollment_id', $this->id)->where('curriculum_id', $curriculum_id)->get()->unique();
            return $courses;
        });

        $courses_id = Arr::flatten($coursesPivot)[0]->id;

        $subjectsPivot = Arr::flatten($coursesPivot)[0]->enrolledSubjects()->where('curriculum_id', $curriculum_id)
            ->where('course_id', $courses_id)->get()->unique();

        return [
            'id' => $this->id,
            'enrollment_code' => $this->enrollment_code,
            'student_id' => $this->student_id,
            'remarks' => $this->remarks,
            'school_year' => $this->school_year,
            'sem' => $this->sem,
            'credits' => $this->credits,
            'status' => $this->status,
            // 'curriculum' => new CurriculumResource($this->id),
            // 'curriculum' => $this->relationLoaded('curricula') ? $this->curricula->pluck('curriculum_id')->unique()->all() : null,
            'curriculum' => $curriculum_unique,
            'course' => Arr::flatten($coursesPivot),
            'subjects' => Arr::flatten($subjectsPivot)
        ];
    }
}
