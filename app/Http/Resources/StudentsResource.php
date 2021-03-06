<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Models\Standard\Standard;

class StudentsResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'first_name'      => $this->first_name,
            'last_name'       => $this->last_name,
            'gender'          => $this->gender,
            'hobbies'         => $this->hobbies,
            'profile_picture' => $this->profile_picture,
            'standard'        => Standard::where('id', $this->standard)->first()->name,
            'created_at'      => optional($this->created_at)->toDateString(),
            'created_by'      => (is_null($this->user_name)) ? optional($this->owner)->first_name : $this->user_name,
        ];
    }
}
