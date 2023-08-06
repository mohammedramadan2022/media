<?php

namespace App\Http\Controllers\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Facade\Support\Core\Warning;
use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\User\{CheckConfirmPhoneCodeRequest,
    NewsletterSubscriptionRequest,
    ResendConfirmPhoneCodeRequest,
    SetUserJoinRequest};
use App\Http\Resources\User\HomePageResource;
use App\Models\{Address, Banner, City, Demand, Feature, Preview, Product, Provider, Section, Subject};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Newsletter\Facades\Newsletter;

class AppController extends PARENT_API
{
    public function getHomePage(): JsonResponse
    {
        $data['banners'] = Banner::active()->get();
        $data['sections'] = Section::active()->with('translation')->limit(10)->get();
        $data['cities'] = City::active()->with('translation')->limit(10)->get();
        $data['previews'] = Preview::active()->with('section.translation')->latest()->limit(2)->get();
        $data['features'] = Feature::active()->latest()->limit(3)->get();
        $data['stores'] = Provider::active()->with(['city.translation', 'rates'])->limit(12)->get();
        $data['popular'] = Product::rentalProducts()->with(['translation', 'images', 'section.translation', 'category.translation'])->popular()->limit(10)->get();
        $data['address'] = Address::getDefault();

        return ApiResponse::response(HomePageResource::make((object)$data));
    }

    public function getAllCities(): JsonResponse
    {
        return City::apiGetAllCities();
    }

    public function getCitiesHasProducts(): JsonResponse
    {
        return City::apiGetCitiesHasProducts();
    }

    public function getAllSections(): JsonResponse
    {
        return Section::apiGetAllSections();
    }

    public function getAllSubjects(Request $request): JsonResponse
    {
        return Subject::apiGetAllSubjects($request);
    }

    public function getPopularProducts(): JsonResponse
    {
        return Product::apiGetPopularProducts();
    }

    public function getMetaInfo(): JsonResponse
    {
        return ApiResponse::response([
            'author'          => getSetting('seo_author'),
            'twitter_title'   => getSetting('seo_twitter_title'),
            'twitter_site'    => getSetting('seo_twitter_site'),
            'twitter_creator' => getSetting('seo_twitter_creator'),
            'description'     => getTransSetting('contact_description'),
            'keywords'        => getSetting('contact_tags'),
            'image'           => get_settings_image('seo_image_logo'),
            'name'            => getTransSetting('app_name'),
        ]);
    }

    public function newsletterSubscription(NewsletterSubscriptionRequest $request): JsonResponse
    {
        if (Newsletter::isSubscribed($request->email)) return Warning::sorryYouAreAlreadySubscribed();

        Newsletter::subscribe($request->email);

        return ApiResponse::success();
    }
}
