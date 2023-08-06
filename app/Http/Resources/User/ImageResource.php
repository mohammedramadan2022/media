<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'    => $this->id,
            'image' => self::imageUrl($this),
        ];
    }

    public static function imageUrl($imageable)
    {
        return asset_url('/storage/uploaded/' . plural(getModelName($imageable->imageable_type))->lower() . '/' . $imageable->image);
    }
}
