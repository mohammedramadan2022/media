<?php

namespace App\Http\Controllers\Api;

use App\Facade\Support\Core\ApiResponse;
use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\User\ContactUsRequest;
use App\Http\Resources\User\FaqResource;
use App\Models\Contact;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;

class PageController extends PARENT_API
{
    public function getAboutUsPage(): JsonResponse
    {
        $setting = getSetting('about_app_' . app()->getLocale()) ?? '';

        return ApiResponse::response(['content' => $setting, 'file' => '']);
    }

    public function getTermsPage(): JsonResponse
    {
        $setting = getTransSetting('terms') ?? '';

        return ApiResponse::response(['content' => $setting, 'file' => '']);
    }

    public function getPrivacyPage(): JsonResponse
    {
        $setting = getTransSetting('policy') ?? '';

        return ApiResponse::response(['content' => $setting, 'file' => '']);
    }

    public function getContractTermsPage(): JsonResponse
    {
        return ApiResponse::dynamicPages('contract_terms');
    }

    public function getWhatWeProvideForYou(): JsonResponse
    {
        return ApiResponse::dynamicPages('what_do_we_provide_for_you');
    }

    public function getFaqsPage(): JsonResponse
    {
        return ApiResponse::response(FaqResource::collection(Faq::active()->get()));
    }

    public function getContactUsInfo(): JsonResponse
    {
        $location = explode(',', (string)getSetting('contact_location'));

        return ApiResponse::response([
            'logo'                   => get_settings_image('site_logo'),
            'footer_logo'            => get_settings_image('site_logo_footer'),
            'description'            => getTransSetting('contact_description'),
            'work_times'             => getTransSetting('contact_times'),
            'address'                => getTransSetting('contact_address'),
            'customer_service'       => getSetting('contact_phone') ? getFormattedPhone(getSetting('contact_phone')) : null,
            'location'               => ['lat' => head($location), 'lng' => last($location)],
            'facebook'               => getSetting('contact_facebook'),
            'twitter'                => getSetting('contact_twitter'),
            'linkedin'               => getSetting('contact_linkedin'),
            'instagram'              => getSetting('contact_instagram'),
            'whatsapp'               => getSetting('contact_whatsapp') ? getFormattedPhone(getSetting('contact_whatsapp')) : null,
            'email'                  => getSetting('contact_email'),
            'mobile'                 => getSetting('contact_mobile') ? getFormattedPhone(getSetting('contact_mobile')) : null,
            'name'                   => getTransSetting('app_name'),
            'contact_section_status' => (bool)getSetting('contact_section_status'),
        ]);
    }

    public function contactUsMessage(ContactUsRequest $request): JsonResponse
    {
        return Contact::apiCreateContactMessage($request);
    }
}
