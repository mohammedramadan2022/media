<?php

use App\Http\Controllers\Api\{AppController, CronJobController, PageController};
use App\Http\Controllers\Api\Auth\{AuthController, AuthEmployeeController};
use App\Http\Controllers\Api\Employee\{AdvanceController, DeliveryMangerController, DeliveryProviderController};
use App\Http\Controllers\Api\Employee\{OrderController as EmployeeOrderController, OrdersOfficerController};
use App\Http\Controllers\Api\Employee\{PageController as EmployeePageController, VacationController, WarehouseMangerController};
use App\Http\Controllers\Api\User\{AddressController, FavoriteController, NotificationController, OrderController};
use App\Http\Controllers\Api\User\{PaymentController, ProductController, ShoppingCartController};
use App\Http\Controllers\Api\User\{StoreController, WalletController, DemandController};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceDoctor within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->group(function () {
    // Pages
    Route::any('gitPull', [CronJobController::class, 'gitPull']);
    Route::any('setOrderToBeRetrieving', [CronJobController::class, 'setOrderToBeRetrieving']);
    Route::any('getAboutUsPage', [PageController::class, 'getAboutUsPage']);
    Route::any('getTermsPage', [PageController::class, 'getTermsPage']);
    Route::any('getPrivacyPage', [PageController::class, 'getPrivacyPage']);
    Route::any('getFaqsPage', [PageController::class, 'getFaqsPage']);
    Route::any('getWhatWeProvideForYou', [PageController::class, 'getWhatWeProvideForYou']);
    Route::any('getContactUsInfo', [PageController::class, 'getContactUsInfo']);
    Route::any('getMetaInfo', [AppController::class, 'getMetaInfo']);
    Route::any('newsletterSubscription', [AppController::class, 'newsletterSubscription']);
    Route::any('contactUsMessage', [PageController::class, 'contactUsMessage']);

    Route::any('setUserJoinRequest', [DemandController::class, 'setUserJoinRequest']);
    Route::any('resendConfirmPhoneCode', [DemandController::class, 'resendConfirmPhoneCode']);
    Route::any('checkConfirmPhoneCode', [DemandController::class, 'checkConfirmPhoneCode']);
    Route::any('checkDemandExists', [DemandController::class, 'checkDemandExists']);

    Route::any('getAllCities', [AppController::class, 'getAllCities']);
    Route::any('getCitiesHasProducts', [AppController::class, 'getCitiesHasProducts']);
    Route::any('getAllSections', [AppController::class, 'getAllSections']);
    Route::any('getAllSubjects', [AppController::class, 'getAllSubjects']);
    Route::any('getContractTermsPage', [PageController::class, 'getContractTermsPage']);
    Route::any('getAllProducts', [ProductController::class, 'getAllProducts']);
    Route::any('filterProducts', [ProductController::class, 'filterProducts']);
    Route::any('search', [ProductController::class, 'search']);
    Route::any('getSectionWithCategories', [ProductController::class, 'getSectionWithCategories']);
    Route::any('getDefaultSpecForSection', [ProductController::class, 'getDefaultSpecForSection']);
    Route::any('getDefaultSpecForCategory', [ProductController::class, 'getDefaultSpecForCategory']);
    Route::any('getSpecsByCategoryId', [ProductController::class, 'getSpecsByCategoryId']);
    Route::any('getProductsByOptionId', [ProductController::class, 'getProductsByOptionId']);
    Route::any('getCategoriesBySectionId', [ProductController::class, 'getCategoriesBySectionId']);
    Route::any('getAbsoluteSpec', [ProductController::class, 'getAbsoluteSpec']);
    Route::any('getStoreSectionWithCategories', [ProductController::class, 'getStoreSectionWithCategories']);
    Route::any('getCitySectionWithCategories', [ProductController::class, 'getCitySectionWithCategories']);
    Route::any('getStoresProductsByCategoryId', [ProductController::class, 'getStoresProductsByCategoryId']);
    Route::any('getAllOffers', [ProductController::class, 'getAllOffers']);
    Route::any('getProductsByCityId', [ProductController::class, 'getProductsByCityId']);
    Route::any('getProductsBySectionId', [ProductController::class, 'getProductsBySectionId']);
    Route::any('getProductsByCategoryId', [ProductController::class, 'getProductsByCategoryId']);
    Route::any('getAllStores', [StoreController::class, 'getAllStores']);
    Route::any('getStoreById', [StoreController::class, 'getStoreById']);
    Route::any('getStoreRates', [StoreController::class, 'getStoreRates']);
    Route::any('getOffersByStoreId', [StoreController::class, 'getOffersByStoreId']);
    Route::any('getSingleStoreSectionWithCategories', [StoreController::class, 'getSingleStoreSectionWithCategories']);

    // callback urls for online payments
    Route::prefix('payments')->group(function () {
        Route::any('wallet-success', [PaymentController::class, 'walletSuccess']);
        Route::any('wallet-web-success', [PaymentController::class, 'walletWebSuccess']);
        Route::any('pay-success', [PaymentController::class, 'paySuccess']);
        Route::any('pay-delay-success', [PaymentController::class, 'payDelaySuccess']);
        Route::any('pay-delay-web-success', [PaymentController::class, 'payDelayWebSuccess']);
        Route::any('pay-web-success', [PaymentController::class, 'payWebSuccess']);
        Route::any('pay-insurance-success', [PaymentController::class, 'payInsuranceSuccess']);
        Route::any('pay-insurance-web-success', [PaymentController::class, 'payInsuranceWebSuccess']);
    });

    // Users Routes;
    Route::prefix('user')->group(function () {
        Route::any('login', [AuthController::class, 'login']);
        Route::any('sendUserActiveCode', [AuthController::class, 'sendUserActiveCode']);
        Route::any('checkUserActiveCode', [AuthController::class, 'checkUserActiveCode']);
        Route::any('register', [AuthController::class, 'register']);
        Route::any('forgetPassword', [AuthController::class, 'forgetPassword']);
        Route::any('checkResetCode', [AuthController::class, 'checkResetCode']);
        Route::any('resetPassword', [AuthController::class, 'resetPassword']);

        // Home
        Route::any('getHomePage', [AppController::class, 'getHomePage']);
        Route::any('getPopularProducts', [AppController::class, 'getPopularProducts']);
        Route::any('getProductById', [ProductController::class, 'getProductById']);
        Route::any('getSectionsWithCategories', [ProductController::class, 'getSectionsWithCategories']);
        Route::any('getProductRates', [ProductController::class, 'getProductRates']);

        // auth user routes;
        Route::group(['middleware' => ['assign.guard:api', 'checkStatus:api']], function () {
            // Notifications
            Route::any('getUserNotifications', [NotificationController::class, 'getUserNotifications']);
            Route::any('getUserNewNotificationsCount', [NotificationController::class, 'getUserNewNotificationsCount']);
            Route::any('removeUserNotification', [NotificationController::class, 'removeUserNotification']);
            Route::any('deleteUserNotifications', [NotificationController::class, 'deleteUserNotifications']);

            // Rate
            Route::any('setUserProductRate', [ProductController::class, 'setUserProductRate']);
            Route::any('setUserStoreRate', [ProductController::class, 'setUserStoreRate']);

            // Profile
            Route::any('updateUserProfile', [AuthController::class, 'updateUserProfile']);
            Route::any('checkUserPhoneActive', [AuthController::class, 'checkUserPhoneActive']);
            Route::any('resendActivePhoneCode', [AuthController::class, 'resendActivePhoneCode']);
            Route::any('activeUserPhone', [AuthController::class, 'activeUserPhone']);
            Route::any('resendUserPhoneCode', [AuthController::class, 'resendUserPhoneCode']);
            Route::any('changeUserPassword', [AuthController::class, 'changeUserPassword']);
            Route::any('getUpdatedProfile', [AuthController::class, 'getUpdatedProfile']);
            Route::any('changePassword', [AuthController::class, 'changePassword']);
            Route::any('deactivateUserAccount', [AuthController::class, 'deactivateUserAccount']);
            Route::any('logout', [AuthController::class, 'logout']);

            // Addresses
            Route::any('getAllAddresses', [AddressController::class, 'getAllAddresses']);
            Route::any('getAddressById', [AddressController::class, 'getAddressById']);
            Route::any('addNewAddress', [AddressController::class, 'addNewAddress']);
            Route::any('deleteUserAddress', [AddressController::class, 'deleteUserAddress']);
            Route::any('updateUserAddress', [AddressController::class, 'updateUserAddress']);
            Route::any('makeCartEmpty', [AddressController::class, 'makeCartEmpty']);
            Route::any('setDefaultAddress', [AddressController::class, 'setDefaultAddress']);
            Route::any('changeDefaultAddress', [AddressController::class, 'changeDefaultAddress']);

            // Favorites
            Route::any('setOrRemoveUserProductFavorite', [FavoriteController::class, 'setOrRemoveUserProductFavorite']);
            Route::any('getUserFavorites', [FavoriteController::class, 'getUserFavorites']);

            // Shopping Cart
            Route::any('addProductToCart', [ShoppingCartController::class, 'addProductToCart']);
            Route::any('getUserCartContent', [ShoppingCartController::class, 'getUserCartContent']);
            Route::any('removeProductFromCart', [ShoppingCartController::class, 'removeProductFromCart']);
            Route::any('applyCoupon', [ShoppingCartController::class, 'applyCoupon']);
            Route::any('changeProductQty', [ShoppingCartController::class, 'changeProductQty']);
            Route::any('completeUserOrder', [ShoppingCartController::class, 'completeUserOrder']);
            Route::any('validateShoppingCartDates', [ShoppingCartController::class, 'validateShoppingCartDates']);
            Route::any('validateHourlyShoppingCartDates', [ShoppingCartController::class, 'validateHourlyShoppingCartDates']);
            Route::any('calculateDatesDays', [ShoppingCartController::class, 'calculateDatesDays']);
            Route::any('calculateDatesHours', [ShoppingCartController::class, 'calculateDatesHours']);
            Route::any('applyCouponWithDates', [ShoppingCartController::class, 'applyCouponWithDates']);

            // Wallet
            Route::any('getUserWallet', [WalletController::class, 'getUserWallet']);
            Route::any('chargeWallet', [WalletController::class, 'chargeWallet']);

            // Orders
            Route::any('getUserOrders', [OrderController::class, 'getUserOrders']);
            Route::any('getOrderById', [OrderController::class, 'getOrderById']);
            Route::any('changeUserOrderAddress', [OrderController::class, 'changeUserOrderAddress']);
            Route::any('changeUserOrderDates', [OrderController::class, 'changeUserOrderDates']);
            Route::any('cancelUserOrder', [OrderController::class, 'cancelUserOrder']);
            Route::any('setUserOrderPay', [OrderController::class, 'setUserOrderPay']);
            Route::any('filterUserOrders', [OrderController::class, 'filterUserOrders']);
            Route::any('setUserOrderPayCash', [OrderController::class, 'setUserOrderPayCash']);
            Route::any('setUserOrderPayByWallet', [OrderController::class, 'setUserOrderPayByWallet']);
            Route::any('setUserPayInsurance', [OrderController::class, 'setUserPayInsurance']);
            Route::any('getOrderStoresLocations', [OrderController::class, 'getOrderStoresLocations']);
            Route::any('getOrderUndertaking', [OrderController::class, 'getOrderUndertaking']);
            Route::any('setUserOrderUndertakingAction', [OrderController::class, 'setUserOrderUndertakingAction']);
            Route::any('setUserThrowbackDemand', [OrderController::class, 'setUserThrowbackDemand']);
            Route::any('setUserDelayPay', [OrderController::class, 'setUserDelayPay']);
            Route::any('setUserDelayPayCash', [OrderController::class, 'setUserDelayPayCash']);
            Route::any('setUserDelayPayByWallet', [OrderController::class, 'setUserDelayPayByWallet']);
        });
    });

    // Employee routes
    Route::prefix('employee')->group(function () {
        // Authentication
        Route::any('login', [AuthEmployeeController::class, 'login']);
        Route::any('sendUserActiveCode', [AuthEmployeeController::class, 'sendUserActiveCode']);
        Route::any('checkUserActiveCode', [AuthEmployeeController::class, 'checkUserActiveCode']);
        Route::any('forgetPassword', [AuthEmployeeController::class, 'forgetPassword']);
        Route::any('checkResetCode', [AuthEmployeeController::class, 'checkResetCode']);
        Route::any('resetPassword', [AuthEmployeeController::class, 'resetPassword']);

        // Pages
        Route::any('getHumanResourcesPage', [EmployeePageController::class, 'getHumanResourcePage']);
        Route::any('getCoursesPage', [EmployeePageController::class, 'getCoursesPage']);
        Route::any('getVacationTypes', [VacationController::class, 'getVacationTypes']);

        Route::group(['middleware' => ['assign.guard:admin_api', 'checkStatus:admin_api']], function () {
            // Profile
            Route::any('getUpdatedProfile', [AuthEmployeeController::class, 'getUpdatedProfile']);
            Route::any('updateEmployeeProfile', [AuthEmployeeController::class, 'updateEmployeeProfile']);
            Route::any('checkEmployeePhoneActive', [AuthEmployeeController::class, 'checkEmployeePhoneActive']);
            Route::any('resendActivePhoneCode', [AuthEmployeeController::class, 'resendActivePhoneCode']);
            Route::any('deactivateUserAccount', [AuthEmployeeController::class, 'deactivateUserAccount']);
            Route::any('getNotificationsPage', [AuthEmployeeController::class, 'getNotificationsPage']);
            Route::any('setEmployeeWorkStatus', [AuthEmployeeController::class, 'setEmployeeWorkStatus']);
            Route::any('search', [AuthEmployeeController::class, 'search']);
            Route::any('logout', [AuthEmployeeController::class, 'logout']);

            // Vacations
            Route::any('setEmployeeVacationDemand', [VacationController::class, 'setEmployeeVacationDemand']);
            Route::any('getEmployeeVacationDemands', [VacationController::class, 'getEmployeeVacationDemands']);

            // Advances
            Route::any('setEmployeeAdvanceDemand', [AdvanceController::class, 'setEmployeeAdvanceDemand']);
            Route::any('getEmployeeAdvanceDemands', [AdvanceController::class, 'getEmployeeAdvanceDemands']);

            // Orders
            Route::any('setOrderUndertaking', [OrdersOfficerController::class, 'setOrderUndertaking']);
            Route::any('getOrdersOfficerNewOrders', [OrdersOfficerController::class, 'getOrdersOfficerNewOrders']);
            Route::any('getOngoingForOrdersOfficer', [OrdersOfficerController::class, 'getOngoingForOrdersOfficer']);
            Route::any('getFinishedForOrdersOfficer', [OrdersOfficerController::class, 'getFinishedForOrdersOfficer']);

            Route::any('getWarehouseMangerNewOrders', [WarehouseMangerController::class, 'getWarehouseMangerNewOrders']);

            Route::any('getDeliveryMangerOrders', [DeliveryMangerController::class, 'getDeliveryMangerOrders']);
            Route::any('getDeliveryProvidersList', [DeliveryMangerController::class, 'getDeliveryProvidersList']);
            Route::any('setOrderDeliveryProvider', [DeliveryMangerController::class, 'setOrderDeliveryProvider']);
            Route::any('getOngoingOrdersDeliveriesForDeliveryManger', [DeliveryMangerController::class, 'getOngoingOrdersDeliveriesForDeliveryManger']);
            Route::any('getOngoingOrdersReceiptsForDeliveryManger', [DeliveryMangerController::class, 'getOngoingOrdersReceiptsForDeliveryManger']);
            Route::any('getFinishedOrdersDeliveriesForDeliveryManger', [DeliveryMangerController::class, 'getFinishedOrdersDeliveriesForDeliveryManger']);
            Route::any('getFinishedOrdersReceiptsForDeliveryManger', [DeliveryMangerController::class, 'getFinishedOrdersReceiptsForDeliveryManger']);

            Route::any('getDeliveryProviderNewOrders', [DeliveryProviderController::class, 'getDeliveryProviderNewOrders']);
            Route::any('getOngoingDeliveriesForDeliveryProvider', [DeliveryProviderController::class, 'getOngoingDeliveriesForDeliveryProvider']);
            Route::any('getOngoingReceiptsForDeliveryProvider', [DeliveryProviderController::class, 'getOngoingReceiptsForDeliveryProvider']);
            Route::any('setDeliveryProviderAction', [DeliveryProviderController::class, 'setDeliveryProviderAction']);
            Route::any('getFinishedOrdersDeliveriesForDeliveryProvider', [DeliveryProviderController::class, 'getFinishedOrdersDeliveriesForDeliveryProvider']);
            Route::any('getFinishedOrdersReceiptsForDeliveryProvider', [DeliveryProviderController::class, 'getFinishedOrdersReceiptsForDeliveryProvider']);

            Route::any('setEmployeeOrderAction', [EmployeeOrderController::class, 'setEmployeeOrderAction']);
            Route::any('getOrderDetailsById', [EmployeeOrderController::class, 'getOrderDetailsById']);
        });
    });
});
