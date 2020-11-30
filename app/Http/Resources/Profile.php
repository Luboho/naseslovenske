<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Profile extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'profile_id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'image' => $this->image,
                'last_updated' => $this->updated_at->diffForHumans(), // Carbon instance method.
            ],
            'links' => [
                'self' => $this->path(),
            ]
        ];
    }
}
