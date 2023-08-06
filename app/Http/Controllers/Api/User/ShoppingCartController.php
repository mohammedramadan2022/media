<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\PARENT_API;
use App\Http\Requests\Api\User\cart\{AddProductToCartRequest, ApplyCouponRequest, ApplyCouponWithDatesRequest};
use App\Http\Requests\Api\User\cart\{CalculateDatesDaysRequest, CalculateDatesHoursRequest, ChangeProductQtyRequest};
use App\Http\Requests\Api\User\cart\{CompleteUserOrderRequest, RemoveProductFromCartRequest, ValidateShoppingCartDatesRequest};
use App\Models\Cart;
use Illuminate\Http\JsonResponse;

class ShoppingCartController extends PARENT_API
{
    public function addProductToCart(AddProductToCartRequest $request): JsonResponse
    {
        return Cart::apiAddProductToCart($request);
    }

    public function getUserCartContent(): JsonResponse
    {
        return Cart::apiGetUserCartContent();
    }

    public function removeProductFromCart(RemoveProductFromCartRequest $request): JsonResponse
    {
        return Cart::apiRemoveProductFromCart($request);
    }

    public function applyCoupon(ApplyCouponRequest $request): JsonResponse
    {
        return Cart::apiApplyCoupon($request);
    }

    public function changeProductQty(ChangeProductQtyRequest $request): JsonResponse
    {
        return Cart::apiChangeProductQty($request);
    }

    public function completeUserOrder(CompleteUserOrderRequest $request): JsonResponse
    {
        return Cart::apiCompleteUserOrder($request);
    }

    public function validateShoppingCartDates(ValidateShoppingCartDatesRequest $request): JsonResponse
    {
        return Cart::apiValidateShoppingCartDates($request);
    }

    public function calculateDatesDays(CalculateDatesDaysRequest $request): JsonResponse
    {
        return Cart::apiCalculateDatesDays($request);
    }

    public function calculateDatesHours(CalculateDatesHoursRequest $request): JsonResponse
    {
        return Cart::apiCalculateDatesHours($request);
    }

    public function applyCouponWithDates(ApplyCouponWithDatesRequest $request): JsonResponse
    {
        return Cart::apiApplyCouponWithDates($request);
    }
}
