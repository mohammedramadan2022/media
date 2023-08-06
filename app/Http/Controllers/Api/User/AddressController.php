<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\User\{AddNewAddressRequest, DeleteUserAddressRequest, UpdateUserAddressRequest};
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AddressController extends PARENT_API
{
    public function getAllAddresses(Request $request): JsonResponse
    {
        return Address::apiGetAllAddresses($request);
    }

    public function addNewAddress(AddNewAddressRequest $request): JsonResponse
    {
        return Address::apiAddNewAddress($request);
    }

    public function deleteUserAddress(DeleteUserAddressRequest $request): JsonResponse
    {
        return Address::apiDeleteUserAddress($request);
    }

    public function getAddressById(DeleteUserAddressRequest $request): JsonResponse
    {
        return Address::apiGetAddressById($request);
    }

    public function setDefaultAddress(DeleteUserAddressRequest $request): JsonResponse
    {
        return Address::apiSetDefaultAddress($request);
    }

    public function changeDefaultAddress(DeleteUserAddressRequest $request): JsonResponse
    {
        return Address::apiChangeDefaultAddress($request);
    }

    public function updateUserAddress(UpdateUserAddressRequest $request): JsonResponse
    {
        return Address::apiUpdateUserAddress($request);
    }

    public function makeCartEmpty(UpdateUserAddressRequest $request): JsonResponse
    {
        return Address::apiMakeCartEmpty($request);
    }
}
