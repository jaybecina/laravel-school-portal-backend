<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClubResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        $studentMembers_unique = $this->students->unique();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'details' => $this->details,
            'imagename' => $this->imagename,
            'path' => $this->path,
            'is_active' => $this->is_active,
            'student_members' => $studentMembers_unique
        ];
    }
}
