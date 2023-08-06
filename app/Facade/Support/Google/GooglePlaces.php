<?php

namespace App\Facade\Support\Google;

use App\Facade\Support\Category;
use App\Facade\Support\Place;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\{DB, Storage, Http};

class GooglePlaces
{
    public static function googleSearchByLatLng($lat, $lng, $exists): bool
    {
        try
        {
            $response = Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$lat.','.$lng.'&rankby=distance&key='.getSetting('map_api'));

            $jsonResponse = $response->json();

            $nextPageToken = isset($jsonResponse['next_page_token']) ?  $jsonResponse['next_page_token'] : "";

            $new_places = isset($jsonResponse['results']) ? collect($jsonResponse['results']) : [];

            //   dd($new_places);

            // dd(Category::whereIn('name_ar',$new_places[0]['types'])->get());

            $new_places_id = $new_places->pluck('place_id');

            // dd($new_places_id);

            $new = $new_places_id->diff($exists);

            // dd($new);

            $new_places->whereIn('place_id', $new);

            // dd($nextPageToken);

            // dd($new_places);

            self::createPlaces($new_places);

            self::googlePlacesByPageToken($nextPageToken);

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public static function googlePlaceDetails($place_id): bool
    {
        $place = Place::find($place_id);

        $response = Http::get('https://maps.googleapis.com/maps/api/place/details/json?place_id='.$place->google_place_id.'&fields=name,formatted_phone_number,business_status,rating,opening_hours&key='.getSetting('map_api'));

        $jsonResponse = $response->json();

        if(isset($jsonResponse['result']['opening_hours']))
        {
            $place->periods = $jsonResponse['result']['opening_hours']['periods'];

            $place->times = $jsonResponse['result']['opening_hours']['weekday_text'];

            $place->save();
        }

        return true;
    }

    public static function googleSearchByCategory($lat, $lng, $type, $exists): bool
    {
        try
        {
            $response = Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json?location='.$lat.','.$lng.'&rankby=distance&type='.$type.'&key='.getSetting('map_api'));

            $jsonResponse = $response->json();

            $nextPageToken = isset($jsonResponse['next_page_token']) ?  $jsonResponse['next_page_token'] : "";

            $new_places = isset($jsonResponse['results']) ? collect($jsonResponse['results']) : [];

            $category = Category::where('key', $type)->first();

            self::googlePlacesByPageToken($nextPageToken);

            //  dd($new_places);

            // dd(Category::whereIn('name_ar',$new_places[0]['types'])->get());

            $new_places_id = $new_places->pluck('place_id');

            // dd($new_places_id);

            $new = $new_places_id->diff($exists);

            // dd($new);

            $new_places->whereIn('place_id', $new);

            // dd($new_places);

            self::createPlaces($new_places, $category->id);

            return true;

        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public static function googleSearchByKeyWord($lat, $lng, $keyword, $exists): bool
    {
        try
        {
            // dd($keyword);

            $response = Http::get('https://maps.googleapis.com/maps/api/textsearch/json/json?query='.$keyword.'&location='.$lat.','.$lng.'&radius=200000000&key='.getSetting('map_api'));

            $jsonResponse = $response->json();

            $nextPageToken = isset($jsonResponse['next_page_token']) ?  $jsonResponse['next_page_token'] :   "";

            $new_places = isset($jsonResponse['results']) ? collect($jsonResponse['results']) : [];

            if($nextPageToken != "")
            {
                self::googlePlacesByPageToken($nextPageToken);
            }

            // dd(Category::whereIn('name_ar',$new_places[0]['types'])->get());

            if(count($new_places) > 0)
            {
                $new_places_id = $new_places->pluck('place_id');

                // dd($new_places_id);

                $new = $new_places_id->diff($exists);

                // dd($new);

                $new_places->whereIn('place_id',$new);

                // dd($new_places);

                self::createPlaces($new_places);
            }

            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }

    public static function point2pointDistance($lat1, $lon1, $lat2, $lon2, $unit = 'K'): float
    {
        $theta = $lon1 - $lon2;

        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));

        $dist = acos($dist);

        $dist = rad2deg($dist);

        $miles = $dist * 60 * 1.1515;

        $unit = strtoupper($unit);

        if ($unit == "K") return ($miles * 1.609344);

        else if ($unit == "N") return ($miles * 0.8684);

        else if($unit =='M') return ($miles * $miles * 1609.344);

        else return round($miles,2);
    }

    public static function checkIfGooglePlaceIsOpen($id): bool
    {
        $place = Place::find($id);

        $data = $place->periods;

        if(!$place->periods) return false;

        elseif(count(json_decode($place->periods)) == 1) return true;

        else
        {
            $currentDayNumber = now()->dayOfWeek;

            $data  = collect(json_decode($place->periods))->where('open.day',$currentDayNumber)->pluck('close.time','open.time');

            $check = false ;

            foreach($data as $key => $value)
            {
                $key   = strval($key);
                $value = strval($value);
                $now   = now()->addHours(2);
                $start = Carbon::createFromFormat('H:i',strtotime( $key));
                $end   = Carbon::createFromFormat('H:i',strtotime($value));
                //   dd($currentDayNumber, $now, $start, $end , $now->between($start, $end));
                if( $end > $now && $now >= $start) $check = true;
            }
            return  $check;
        }
    }

    public static function getLocationInfoByLatAndLng($lat, $lng)
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$lat.','.$lng.'&sensor=true&key='.getSetting('map_api'))->json();

        return $response['results'][0]['address_components'][2]['long_name'];
    }

    private static function googlePlacesByPageToken($oldNextPageToken): void
    {
        $response = Http::get('https://maps.googleapis.com/maps/api/place/nearbysearch/json?pagetoken='.$oldNextPageToken.'&key='.getSetting('map_api'));

        $jsonResponse = $response->object();

        $nextPageToken = $jsonResponse->next_page_token ?? "";

        $places = $jsonResponse->results ?: [];

        self::createPlaces($places);

        if($nextPageToken != "") self::googlePlacesByPageToken($nextPageToken);
    }

    private static function createPlaces($data, $category_id = 0): void
    {
        DB::beginTransaction();
        try
        {
            foreach ($data as $key => $value)
            {
                $oldPlace = Place::whereGooglePlaceId($value['place_id'])->first();

                if(!$oldPlace)
                {
                    $insertData = Place::create([
                        'lat' => $value['geometry']['location']['lat'],
                        'lng' => $value['geometry']['location']['lng'],
                        'google_place_id' => $value['place_id'],
                        // 'formatted_address'=>isset($value['vicinity']) ? $value['vicinity'] : '' ,
                        // 'geometry'=>$value['geometry'],
                        // 'business_status'=>isset($value['business_status']) ?  $value['business_status'] :'',
                        'name' => $value['name'],
                        'icon' => $value['icon'],
                        'category_id' => $category_id,
                        // 'plus_code'=>isset($value['plus_code']) ? $value['plus_code'] :'',
                        // 'reference'=>$value['reference'],
                        // 'types'=>$value['types'],
                        // 'scope'=>isset($value['scope']) ?  $value['scope'] : '',
                        // 'user_ratings_total'=>isset($value['user_ratings_total']) ?  $value['user_ratings_total'] : '' ,
                        //'rating'=>isset($value['rating']) ? $value['rating'] : '',
                    ]);

                    if(isset($value['photos']))
                    {
                        $insertData->update(['cover' => self::googlePlaceSaveImage($value['photos'][0])]);
                    }
                }
            }
            DB::commit();

            return;
        }
        catch (Exception $e)
        {
            DB::rollback();
            return;
        }
    }

    private static function googlePlaceSaveImage($image_value): string
    {
        $photoResponse = Http::get('https://maps.googleapis.com/maps/api/place/photo?maxwidth='.$image_value['width'].'&photoreference='.$image_value['photo_reference'].'&key='.getSetting('map_api'));

        $file_name = 'place_' . time() . '.png'; //generating unique file name;

        Storage::disk('public')->put('uploaded/places/'.$file_name, base64_decode(base64_encode($photoResponse->body())));

        return $file_name;
    }
}
