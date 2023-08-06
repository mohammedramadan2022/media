<?php

namespace App\Facade\Support\Core;

use App\Facade\Support\Tools\CrudMessage;

/**
 * @method static thisAccountIsBlocked()
 * @method static userStatusIsNotActive()
 * @method static phoneAlreadyExists()
 * @method static userCodeInvalid()
 * @method static userIsNotFoundOrNotActived()
 * @method static passwordNotChanged()
 * @method static pleaseActiveYourPhoneFirst()
 * @method static userNotFound()
 * @method static passwordIsNotMatched()
 * @method static courseIsNotActive()
 * @method static doctorIsNotActive()
 * @method static sorryThisCourseNotYours()
 * @method static userAlreadySubscribeInCourse()
 * @method static sorrySubscriptionNotFound()
 * @method static videoIsAlreadyWatched()
 * @method static videoIsNotFound()
 * @method static sorryThisIsNotYourAccount()
 * @method static providerHasNoBalance()
 * @method static doctorIsNotFound()
 * @method static notificationIsNotFound()
 * @method static adminIsNotFound()
 * @method static chatNotFound()
 * @method static sorryYourRequestIsNotAcceptedYet()
 * @method static sorryYourAccountIsNotAcceptedYet()
 * @method static monumentIsNotFound()
 * @method static thisMonumentIsAlreadyRated()
 * @method static sorryThisTripAlreadyExists()
 * @method static sorryThisAccountIsAlreadyExists()
 * @method static sorryThisDemandIsAlreadyExists()
 * @method static sorryYourDemandIsNotAcceptedYet()
 * @method static sorryTheMembersNumberIsNotCorrect()
 * @method static sorryThisDateNotAvailableForReservation()
 * @method static sorryYouHaveReserveThisTripAlready()
 * @method static sorryAdjustMemberNumber()
 * @method static sorryTheTripReservationCompletedToday()
 * @method static sorryThisReservationAlreadyCanceled()
 * @method static sorryThisTripAlreadyCanceledByProvider()
 * @method static sorryThisTripHasOfferAlready()
 * @method static sorryYourWalletBalanceIsNotEnoughToPay()
 * @method static sorryThisTripAlreadyExistsInCart()
 * @method static cartIsEmpty()
 * @method static sorryThisTripAlreadyRated()
 * @method static invalidPhoneNumber()
 * @method static invalidEmailAddress()
 * @method static sorryThisReservationIsNotExists()
 * @method static trainerNotFound()
 * @method static sorryYouHaveAddedYourTimeTableAlready()
 * @method static sorryThisPackageIsFinished()
 * @method static sorryThisReservationIsAlreadyExists()
 * @method static sorryThisPackageIsAlreadyReserved()
 * @method static hireIsNotFound()
 * @method static productAlreadyAddedToCart()
 * @method static sorryThisProductAlreadyRated()
 * @method static sorryThisProductIsNotInYourCity()
 * @method static sorryYouDoNotHaveAnAddress()
 * @method static sorryThisStoreAlreadyRated()
 * @method static sorryThisDateAlreadyToken()
 * @method static sorryTheEndDateAlreadyToken()
 * @method static sorryThisOrderHasBeenCanceled()
 * @method static sorryYourOrderAddressNotMatchDefaultAddress()
 * @method static sorryPleaseSetAntherAddress()
 * @method static sorryPaymentProcessFailed()
 * @method static addressNotFound()
 * @method static sorryYouAreAlreadySubscribed()
 * @method static sorryOrderStatusNotValid()
 * @method static sorryThisOrderNotPaidYet()
 * @method static sorryThisOrderHasNoProvider()
 * @method static sorryCanNotChangeOrderStatusToPending()
 * @method static sorryThisOrderAlreadyHasProvider()
 * @method static sorryThisProviderIsNotAvailable()
 * @method static sorryThisUndertakingAlreadyAccepted()
 * @method static sorryThisOrderNotExists()
 * @method static sorryThisOrderAlreadySetToReturns()
 * @method static sorryThisProductIsNotAvailable()
 * @method static sorryTheStartDateMustBeInFuture()
 * @method static sorryTheEndDateMustBeInFuture()
 * @method static sorryThisOrderMustBeDelivered()
 * @method static sorryTheTimeBetweenStartDateAndEndDateMustBe24Hours()
 * @method static sorryTheMinDurationToRentingIsHour()
 * @method static sorryTheEndDateMustBeAfterStartDate()
 * @method static sorrySomeOfProductsQtyIsOutOfStock()
 * @method static sorryThisDemandIsNotExists()
 */

class Warning
{
    public static function __callStatic($name, $arguments)
    {
        $message = "Method [$name] does not exist on warnings.";

        $trans = 'api.'.snake($name)->slug();

        if (is_api_path())
        {
            if (trans($trans) === $trans) return ApiResponse::fails($message);

            return ApiResponse::warning(trans($trans));
        }

        if (trans($trans) === $trans) return CrudMessage::error($message);

        if (request()->wantsJson()) return CrudMessage::warning(trans($trans));

        return CrudMessage::error(trans($trans));
    }
}
