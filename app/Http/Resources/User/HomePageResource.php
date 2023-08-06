<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class HomePageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'banners'         => BannerResource::collection($this->banners),
            'sections'        => SectionResource::collection($this->sections),
            'cities'          => CityResource::collection($this->cities),
            'previews'        => PreviewResource::collection($this->previews),
            'features'        => FeatureResource::collection($this->features),
            'stores'          => ProviderResource::collection($this->stores),
            'popular'         => ProductResource::collection($this->popular),
            'default_address' => $this->address ? DefaultAddressResource::make($this->address) : null,
        ];
    }
}
