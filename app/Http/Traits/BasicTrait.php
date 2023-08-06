<?php

namespace App\Http\Traits;

use App\Facade\Support\Core\Crud;
use App\Http\Scopes\BasicScopes;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

/**
 * @method static create(array $array)
 * @method static firstOrcreate(array $array)
 * @method static updateOrCreate(array $array)
 * @method static find(int|array $id, string $column = 'id')
 * @method static findOrFail(int $id)
 * @method static latest()
 * @method static search(string $term)
 * @method static paginate(int $page)
 * @method static whereStatus(int $int)
 * @method static doesntHave(string $column)
 * @method static whereHas(string $relation, callable $callback)
 * @method static has($relation)
 * @method static checkForProduct(Request $request, int $cart_id)
 * @method static getCategoriesByType($type = 0)
 * @method static getSubjectsByType($type = 0)
 * @method static getFaqByType(string $type)
 * @method static whenSubcategoryIs(int $subcategoryId)
 * @method static whenProviderIs(int $providerId)
 * @method static getProvidersByFixedDistance(Request $request)
 * @method static whereProviderStatusIs(int $int)
 * @method static whereHasProviderStatusIs(int $int)
 * @method static whenSubSubjectOrUniversityIs(string $col, int $val)
 * @method static whereCompanyId(int $int)
 * @method static whereParentId(int $int)
 * @method static whereUserId(int $int)
 * @method static whereProviderId(int $int)
 * @method static whereProductId(int $int)
 * @method static whereRoleId(int $int)
 * @method static whereIsSeen(int $int)
 * @method static whenPhoneAndCodeIs($request)
 * @method static whereNotIn($column, $arr)
 * @method static whereEmail($value)
 * @method static wherePhone($value)
 * @method static whereCountryCode($value)
 * @method static whenIdIs($id)
 * @method static getCoupon($name)
 * @method static whereName($value)
 * @method static whereType($value)
 * @method static whereAccepted($value)
 * @method static whereDoctorId(int $id)
 * @method static whereCourseId(int $id)
 * @method static whereVideoId(int $id)
 * @method static checkCouponValidation($coupon)
 * @method static whereUserIdAndDoctorId($user, $doctor)
 * @method static whereJwtAndTokenableType($jwt, $type)
 * @method static getUserVideo(\Illuminate\Http\Request $request, $video)
 * @method static checkUserSubscription(\Illuminate\Http\Request $request)
 * @method static whereBetween($column, array $array)
 * @method static select(string|array $column, Builder $builder = null)
 * @method static reports(\Illuminate\Http\Request $request)
 * @method static allReports()
 * @method static userSearch($term)
 * @method static whereId($id)
 * @method static getAllCourses($doctor)
 * @method static getDoctorsByType($type)
 * @method static whereJwt($value)
 * @method static whereIn($id, $value)
 * @method static whereSubjectId($id)
 * @method static firstOrNew($data)
 * @method static checkForExist($type, $id)
 * @method static whereCountryId($country_id)
 * @method static whereIsComplete($value)
 * @method static wherePhoneAndCountryCode($phone, $country_code)
 * @method static whereSectionIdAndTitle($section, $title)
 * @method static whereTypeAndValue($type, $value)
 * @method static getUserBy($type)
 * @method static whenTypeAndValue($request)
 * @method static checkForExistsReservation($request, $package_reservation = null)
 * @method static whenUserIs($request)
 * @method static whereAction($value)
 * @method static whereNull($column)
 * @method static whereTrainerId($id)
 * @method static whereAreaId($id)
 * @method static whereMobile($mobile)
 * @method static wherePackageId($id)
 * @method static withTranslation()
 * @method static whereSlug($slug)
 * @method static whereIdNot($id)
 * @method static whereIdNotAndStatusTrue($id)
 * @method static withHas($relation)
 * @method static whereYear($column, $year)
 * @method static whereBelongsTo($model, $relation = null)
 * @method static whereCountryIdAndStatus($country, $status)
 * @method static whereSectionId($id)
 * @method static whereHasOffer($value)
 * @method static whenStoreIs($value)
 * @method static whereIsAccepted($value)
 * @method static storeProductsHasOffer($value)
 * @method static sum($column)
 * @method static active()
 * @method static similar($object)
 * @method static rentalProducts()
 * @method static whenStoreExists($request)
 * @method static storeProducts($type_id = 0)
 * @method static whereCategoryId($id)
 * @method static whereCartId($id)
 * @method static whereNotNull($column)
 * @method static whereOrderId($value)
 * @method static whereOrderNo($value)
 * @method static whereAdminId($value)
 * @method static cursor()
 * @method static pending()
 * @method static accepted()
 * @method static processed()
 * @method static processing()
 * @method static rejected()
 * @method static inDelivery()
 * @method static delivered()
 * @method static readyForDelivery()
 * @method static deliveryToWarehouse()
 * @method static retrieving()
 * @method static rejectedByProvider()
 * @method static rejectedFromWarehouse()
 * @method static notReceived()
 * @method static returns()
 * @method static canceled()
 * @method static orPending()
 * @method static orAccepted()
 * @method static orProcessed()
 * @method static orProcessing()
 * @method static orRejected()
 * @method static orInDelivery()
 * @method static orDelivered()
 * @method static orDeliveryToWarehouse()
 * @method static orRetrieving()
 * @method static orReadyForDelivery()
 * @method static orRejectedByProvider()
 * @method static orNotReceived()
 * @method static orRejectedFromWarehouse()
 * @method static orReturns()
 * @method static orCanceled()
 * @method static notSuperAdmin()
 * @method static withRelations()
 */
trait BasicTrait
{
    use BasicScopes;

    public function getSinceAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getLastUpdateAttribute()
    {
        return $this->updated_at->diffForHumans();
    }

    public function getDeletedSinceAttribute()
    {
        return $this->deleted_at->diffForHumans();
    }

    public static function getInSelectForm($name = 'name'): array
    {
        return Crud::getModelsInSelectedForm(self::class, $name);
    }

    public static function slug($name = 'name')
    {
        $request = request();

        return str($request['ar'][$name])->slug();
    }

    public static function beTranslated($except = []): array
    {
        $fields = (new self)->translatedAttributes;

        $modelData = request()->except(['_token', '_method'] + $except);

        foreach ($fields as $field) {
            $modelData['en'][$field] = set_trans_default_value($field);
        }

        return $modelData;
    }
}
