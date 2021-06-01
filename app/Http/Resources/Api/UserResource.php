<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        switch ($request->route()->getActionMethod()) {
            case "index":
                return [
                    "id"     => (int)$this->id,
                    "email"  => (string)$this->email,
                    "name"   => (string)$this->name,
                    "avatar" => (string)$this->avatar,
                ];
        }
    }
}
