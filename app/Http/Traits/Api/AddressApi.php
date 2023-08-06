<?php

namespace App\Http\Traits\Api;

use App\Facade\Support\Core\{ApiResponse, Warning};
use App\Http\Resources\User\AddressResource;
use App\Models\Address;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

trait AddressApi
{
    public static function apiGetAllAddresses($request): JsonResponse
    {
        $addresses = $request->user()->addresses()->with(['city.translation'])->get();

        return ApiResponse::response(AddressResource::collection($addresses));
    }

    public static function apiAddNewAddress($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $data = $request->validated();

            $data['user_id'] = $request->user()->id;

            $address = Address::firstOrcreate($data);

            if (! $request->user()->address_id) {
                $request->user()->update([
                    'address_id' => $address->id,
                    'city_id'    => $address->city_id,
                ]);
            }

            DB::commit();

            return ApiResponse::response(AddressResource::make($address));
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function apiDeleteUserAddress($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            if ($request->user()->address_id == $request->address_id) $request->user()->update(['address_id' => null]);

            Address::destroy($request->address_id);

            DB::commit();

            return ApiResponse::success();
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function apiUpdateUserAddress($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $address = Address::find($request->address_id);

            $address->update([
                'city_id'        => $request->has('city_id') ? $request->city_id : $address->city_id,
                'street'         => $request->has('street') ? $request->street : $address->street,
                'phone'          => $request->has('phone') ? $request->phone : $address->phone,
                'recipient_name' => $request->has('recipient_name') ? $request->recipient_name : $address->recipient_name,
                'special_marque' => $request->has('special_marque') ? $request->special_marque : $address->special_marque,
            ]);

            DB::commit();

            return ApiResponse::response(AddressResource::make($address));
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function apiMakeCartEmpty($request): JsonResponse
    {
        DB::beginTransaction();
        try
        {
            $address = Address::find($request->address_id);

            if ($address->is_address_same_city) DB::table('cart_product')->where('cart_id', $request->user()->cart->id)->delete();

            $address->update([
                'city_id'        => $request->filled('city_id') ? $request->city_id : $address->city_id,
                'street'         => $request->filled('street') ? $request->street : $address->street,
                'phone'          => $request->filled('phone') ? $request->phone : $address->phone,
                'recipient_name' => $request->filled('recipient_name') ? $request->recipient_name : $address->recipient_name,
                'special_marque' => $request->filled('special_marque') ? $request->special_marque : $address->special_marque,
            ]);

            DB::commit();

            return ApiResponse::response(AddressResource::make($address));
        }
        catch (Exception $e)
        {
            DB::rollBack();

            return ApiResponse::exceptionFails($e);
        }
    }

    public static function apiGetAddressById($request): JsonResponse
    {
        $address = Address::find($request->address_id);

        if (! $address) {
            return Warning::addressNotFound();
        }

        return ApiResponse::response(AddressResource::make(Address::find($request->address_id)));
    }

    public static function apiSetDefaultAddress($request): JsonResponse
    {
        $address = Address::find($request->address_id);

        $request->user()->update(['address_id' => $address->id, 'city_id' => $address->city_id]);

        return ApiResponse::response(AddressResource::make($address));
    }

    public static function apiChangeDefaultAddress($request): JsonResponse
    {
        $address = Address::find($request->address_id);

        if ($request->user()->cart && $address->city_id != $request->user()->city_id) {
            DB::table('cart_product')->where('cart_id', $request->user()->cart->id)->delete();
        }

        $request->user()->update(['address_id' => $request->address_id, 'city_id' => $address->city_id]);

        return ApiResponse::response(AddressResource::make($address));
    }
}
