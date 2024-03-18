<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Course;
use Illuminate\Support\Arr;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
        
        // return [
        //     'id' => $this->id,
        //     'name' => $this->name,
        //     'details' => $this->details,
        //     'start_date' => $this->start_date->format('d/m/Y H:i:s'),
        //     'end_date' => $this->end_date->format('d/m/Y H:i:s'),
        //     'speaker_name' => $this->speaker_name,
        //     'created_at' => $this->created_at->format('d/m/Y'),
        //     'updated_at' => $this->updated_at->format('d/m/Y'),
        // ];
    }
}
