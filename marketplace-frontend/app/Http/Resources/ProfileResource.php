<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            $this->mergeWhen(($this->user_type == 4), function () {
                return [
                    'profile_id' => $this->driverprofile->id,
                    'age' => $this->driverprofile->age,
                    'vehicle' => $this->driverprofile->vehicle_no,
                    'gender' => $this->driverprofile->gender,
                    'active' => $this->driverprofile->active,
                    'online' => $this->driverprofile->online,
                ];
            }),
            $this->mergeWhen(($this->user_type == 3), function () {
                return [
                    'areas' => $this->areas,
                ];
            }),

        ];

        //return parent::toArray($request);
    }
}
