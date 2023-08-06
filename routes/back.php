<?php

use App\Http\Controllers\Back\{ActivityController, AdminController, AdvanceController};
use App\Http\Controllers\Back\Auth\AdminLoginController;
use App\Http\Controllers\Back\{BannerController, CategoryController, CityController};
use App\Http\Controllers\Back\{ContactController, CouponController, CourseController};
use App\Http\Controllers\Back\{DashboardController, DemandController, FaqController};
use App\Http\Controllers\Back\{FeatureController, HumanResourceController, OrderController};
use App\Http\Controllers\Back\{PaymentController, PreviewController, ProductController};
use App\Http\Controllers\Back\{ProviderController, ReportController, RoleController};
use App\Http\Controllers\Back\{SectionController, SettingController, SpecController};
use App\Http\Controllers\Back\{SubjectController, ThrowbackController, UserController};
use App\Http\Controllers\Back\{VacationController, VacationTypeController};
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::namespace('Auth')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::get('/forget-password', [AdminLoginController::class, 'forgetPassword'])->name('admin.forget-password');
    Route::post('/forget-password-submit', [AdminLoginController::class, 'sendResetMail'])->name('admin.forget-password-submit');
    Route::get('/confirmed-reset-mail', [AdminLoginController::class, 'confirmedResetMail'])->name('admin.confirmedResetMail');
    Route::get('/admin-reset-password/{token}', [AdminLoginController::class, 'adminResetPassword'])->name('admin.reset-password');
    Route::post('/admin-change-password', [AdminLoginController::class, 'adminChangePassword'])->name('admin.changePassword');
    Route::post('/login', [AdminLoginController::class, 'adminLogin'])->name('admin.submit.login');
    Route::post('/logout', [AdminLoginController::class, 'adminLogout'])->name('admin.logout');
});

Route::group(['middleware' => ['auth:admin', 'CheckAdminRole', 'check.debug.mode', 'CheckAdminStatus']], function () {
    // Dashboard
    Route::view('/not-found', 'Back.layouts.not-found')->name('admin.not-found');
    Route::get('/', [DashboardController::class, 'index'])->name('admin-panel');
    Route::get('logs', [LogViewerController::class, 'index']);
    Route::get('/search', [DashboardController::class, 'search'])->name('search');

    Route::crud('roles', RoleController::class);
    Route::crud('faqs', FaqController::class);
    Route::crud('sections', SectionController::class);
    Route::crud('banners', BannerController::class);
    Route::crud('cities', CityController::class);
    Route::crud('categories', CategoryController::class);
    Route::crud('previews', PreviewController::class);
    Route::crud('features', FeatureController::class);
    Route::crud('providers', ProviderController::class);
    Route::crud('products', ProductController::class);
    Route::crud('subjects', SubjectController::class, false);
    Route::crud('coupons', CouponController::class, false);
    Route::crud('humanResources', HumanResourceController::class);
    Route::crud('courses', CourseController::class, false);
    Route::crud('specs', SpecController::class);
    Route::group(['as' => 'specs.', 'prefix' => 'specs'], function () {
        Route::post('/ajax-remove-option-by-id', [SpecController::class, 'removeOptionById'])->name('ajax-remove-option-by-id');
    });

    Route::get('/vacations', [VacationController::class, 'index'])->name('vacations.index');
    Route::post('/vacations/ajax-delete-vacation', [VacationController::class, 'delete'])->name('vacations.ajax-delete-vacation');
    Route::get('/vacations/{vacation}/show', [VacationController::class, 'show'])->name('vacations.show');
    Route::get('/vacations/restore/{id}/trashed', [VacationController::class, 'restore'])->name('vacations.restore');
    Route::get('/vacations/delete/{id}/trashed', [VacationController::class, 'forceDelete'])->name('vacations.delete');
    Route::get('/vacations/trashed', [VacationController::class, 'trashed'])->name('vacations.trashed');
    Route::get('/vacations/search', [VacationController::class, 'search'])->name('vacations.search');
    Route::get('/vacations/export', [VacationController::class, 'export'])->name('vacations.export');
    Route::get('/vacations/{vacation}/accept', [VacationController::class, 'accept'])->name('vacations.accept');
    Route::get('/vacations/{vacation}/refuse', [VacationController::class, 'refuse'])->name('vacations.refuse');

    Route::crud('vacationTypes', VacationTypeController::class, false);

    Route::get('/advances', [AdvanceController::class, 'index'])->name('advances.index');
    Route::post('/advances/ajax-delete-advance', [AdvanceController::class, 'delete'])->name('advances.ajax-delete-advance');
    Route::get('/advances/{advance}/show', [AdvanceController::class, 'show'])->name('advances.show');
    Route::get('/advances/restore/{id}/trashed', [AdvanceController::class, 'restore'])->name('advances.restore');
    Route::get('/advances/delete/{id}/trashed', [AdvanceController::class, 'forceDelete'])->name('advances.delete');
    Route::get('/advances/trashed', [AdvanceController::class, 'trashed'])->name('advances.trashed');
    Route::get('/advances/search', [AdvanceController::class, 'search'])->name('advances.search');
    Route::get('/advances/export', [AdvanceController::class, 'export'])->name('advances.export');
    Route::get('/advances/{advance}/accept', [AdvanceController::class, 'accept'])->name('advances.accept');
    Route::get('/advances/{advance}/refuse', [AdvanceController::class, 'refuse'])->name('advances.refuse');

    Route::group(['as' => 'throwbacks.', 'prefix' => 'throwbacks'], function () {
        Route::get('/', [ThrowbackController::class, 'index'])->name('index');
        Route::get('/search', [ThrowbackController::class, 'search'])->name('search');
        Route::get('/{throwback}/show', [ThrowbackController::class, 'show'])->name('show');
        Route::get('/export', [ThrowbackController::class, 'export'])->name('export');
        Route::get('/{throwback}/accept', [ThrowbackController::class, 'accept'])->name('accept');
        Route::get('/{throwback}/refuse', [ThrowbackController::class, 'refuse'])->name('refuse');
    });

    Route::group(['as' => 'products.', 'prefix' => 'products'], function () {
        Route::post('/getCategoriesBySectionId', [ProductController::class, 'getCategoriesBySectionId'])->name('getCategoriesBySectionId');
        Route::post('/ajax-get-options-by-category-id', [ProductController::class, 'getOptionsByCategoryId'])->name('ajax-get-options-by-category-id');
        Route::get('/{product}/accept', [ProductController::class, 'accept'])->name('accept');
        Route::get('/{product}/reject', [ProductController::class, 'reject'])->name('reject');
    });

    Route::crud('admins', AdminController::class, true, function () {
        Route::get('/admins/admin/profile', [AdminController::class, 'adminProfile'])->name('admins.profile');
        Route::post('/admins/admin/profile', [AdminController::class, 'AdminUpdateProfile'])->name('admins.admin-profile-update');
        Route::get('/admins/mails/{id}/show-admin-message', [AdminController::class, 'showAdminMessage'])->name('admins.show-message');
        Route::post('/admins/send-admin-message', [AdminController::class, 'sendAdminMessage'])->name('admins.send-message');
        Route::post('/admins/send-admin-notification', [AdminController::class, 'sendAdminNotification'])->name('admins.send-notification');
    });

    // admin -> Users Routes
    Route::crud('users',UserController::class);
    Route::group(['as' => 'users.'], function () {
        Route::get('/users/{user}/block', [UserController::class, 'block'])->name('block');
        Route::get('/users/{user}/unblock', [UserController::class, 'unblock'])->name('unblock');
        Route::get('/users/{id}/show-user-message', [UserController::class, 'showUserMessage'])->name('show-message');
        Route::post('/users/send-user-message', [UserController::class, 'sendUserMessage'])->name('send-message');
        Route::post('/users/send-user-notification', [UserController::class, 'sendUserNotification'])->name('send-notification');
        Route::get('/users/show-users-notification', [UserController::class, 'showUsersNotification'])->name('show-users-notification');
        Route::post('/users/send-users-notification', [UserController::class, 'sendUsersNotification'])->name('send-users-notification');
    });

    // admin -> Contacts Routes
    Route::group(['as' => 'contacts.'], function () {
        Route::get('/contacts', [ContactController::class, 'contacts'])->name('index');
        Route::get('/contacts/{contact}/show', [ContactController::class, 'show'])->name('show');
        Route::post('/contacts/ajax-delete-contact', [ContactController::class, 'deleteMessage'])->name('ajax-delete-contact');
        Route::get('/contacts/{id}/message-details', [ContactController::class, 'showMessageDetails'])->name('message-details');
        Route::get('/contacts/{id}/send-message', [ContactController::class, 'sendUserMessage'])->name('send-user-message');
        Route::post('/contacts/users-send-email', [ContactController::class, 'sendUserReplayMessage'])->name('users-send-email');
        Route::get('/contacts/export', [ContactController::class, 'export'])->name('export');
        Route::get('/contacts/search', [ContactController::class, 'search'])->name('search');
    });

    // admin -> Demands Routes
    Route::group(['as' => 'demands.'], function () {
        Route::get('/demands', [DemandController::class, 'index'])->name('index');
        Route::get('/demands/{demand}/show', [DemandController::class, 'show'])->name('show');
        Route::get('/demands/{demand}/accept', [DemandController::class, 'accept'])->name('accept');
        Route::get('/demands/{demand}/reject', [DemandController::class, 'reject'])->name('reject');
        Route::post('/demands/ajax-delete-demand', [DemandController::class, 'delete'])->name('ajax-delete-demand');
        Route::get('/demands/export', [DemandController::class, 'export'])->name('export');
        Route::get('/demands/restore/{id}/trashed', [DemandController::class, 'restore'])->name('restore');
        Route::get('/demands/delete/{id}/trashed', [DemandController::class, 'forceDelete'])->name('delete');
        Route::get('/demands/trashed', [DemandController::class, 'trashed'])->name('trashed');
        Route::get('/demands/search', [DemandController::class, 'search'])->name('search');
    });

    // admin -> Payments Routes
    Route::group(['as' => 'payments.'], function () {
        Route::get('/payments', [PaymentController::class, 'index'])->name('index');
        Route::get('/payments/{payment}/show', [PaymentController::class, 'show'])->name('show');
        Route::post('/payments/ajax-delete-payment', [PaymentController::class, 'delete'])->name('ajax-delete-payment');
        Route::get('/payments/export', [PaymentController::class, 'export'])->name('export');
        Route::get('/payments/restore/{id}/trashed', [PaymentController::class, 'restore'])->name('restore');
        Route::get('/payments/delete/{id}/trashed', [PaymentController::class, 'forceDelete'])->name('delete');
        Route::get('/payments/trashed', [PaymentController::class, 'trashed'])->name('trashed');
        Route::get('/payments/search', [PaymentController::class, 'search'])->name('search');
    });

    // admin -> Orders Routes
    Route::group(['as' => 'orders.'], function () {
        Route::get('/orders', [OrderController::class, 'index'])->name('index');
        Route::get('/orders/types/{type}', [OrderController::class, 'types'])->name('types');
        Route::get('/orders/{order}/show', [OrderController::class, 'show'])->name('show');
        Route::post('/orders/change-status', [OrderController::class, 'changeOrderStatus'])->name('change-order-status');
        Route::get('/orders/{order}/final-accept', [OrderController::class, 'finalAccept'])->name('final-accept');
        Route::get('/orders/{order}/order-cash-paid', [OrderController::class, 'orderCashPaid'])->name('order-cash-paid');
        Route::get('/orders/{order}/delay-cash-paid/{type}', [OrderController::class, 'delayCashPaidAction'])->name('delay-cash-paid');
        Route::get('/orders/{order}/accept', [OrderController::class, 'accept'])->name('accept');
        Route::get('/orders/{order}/reject', [OrderController::class, 'reject'])->name('reject');
        Route::get('/orders/{order}/provider/{provider}/reject-provider-order', [OrderController::class, 'rejectProviderOrder'])->name('reject-provider-order');
        Route::post('/orders/ajax-delete-order', [OrderController::class, 'delete'])->name('ajax-delete-order');
        Route::get('/orders/export', [OrderController::class, 'export'])->name('export');
        Route::get('/orders/search', [OrderController::class, 'search'])->name('search');
        Route::get('/orders/restore/{id}/trashed', [OrderController::class, 'restore'])->name('restore');
        Route::get('/orders/delete/{id}/trashed', [OrderController::class, 'forceDelete'])->name('delete');
        Route::get('/orders/trashed', [OrderController::class, 'trashed'])->name('trashed');
    });

    Route::as('orders.')->prefix('orders')->group(function () {
        Route::post('/{order}/ajax-is-order-accepted', [OrderController::class, 'isOrderAccepted'])->name('ajax-is-order-accepted');
        Route::get('/payment/{order_id}/show-payment-process', [OrderController::class, 'showOrderPaymentProcess'])->name('show-order-payment-process');
        Route::get('/payment/{order_id}/show-order-provider-modal', [OrderController::class, 'showOrderProviders'])->name('show-order-provider-modal');
        Route::post('/payment/set-order-to-be-paid', [OrderController::class, 'setOrderToBePaid'])->name('set-order-to-be-paid');
        Route::post('/providers/set-order-provider', [OrderController::class, 'setOrderProvider'])->name('set-order-provider');
    });

    // admin -> Settings Routes
    Route::resource('settings', SettingController::class, ['only' => ['index', 'store']]);
    Route::post('/settings/update-all', [SettingController::class, 'UpdateAll'])->name('settings.update-all');
    Route::post('/settings/ajax-change-setting-status', [SettingController::class, 'changeStatus'])->name('settings.ajax-change-setting-status');
    Route::group(['as' => 'settings.', 'prefix' => 'settings'], function () {
        Route::get('create', [SettingController::class, 'create'])->name('create');
        Route::get('configurations', [SettingController::class, 'configurations'])->name('configurations');
        Route::get('configurations/{setting}/show', [SettingController::class, 'show'])->name('configurations.show');
        Route::post('configurations/ajax-delete-setting', [SettingController::class, 'delete'])->name('ajax-delete-setting');
        Route::get('configurations/restore/{id}/trashed', [SettingController::class, 'restore'])->name('restore');
        Route::get('configurations/delete/{id}/trashed', [SettingController::class, 'forceDelete'])->name('delete');
        Route::get('configurations/trashed', [SettingController::class, 'trashed'])->name('trashed');
    });

    // admin -> reports
    Route::group(['as' => 'reports.', 'prefix' => 'reports'], function () {
        Route::get('reports', [ReportController::class, 'index'])->name('index');
    });

    // admin -> activities
    Route::group(['as' => 'activities.', 'prefix' => 'activities'], function () {
        Route::get('/', [ActivityController::class, 'index'])->name('index');
        Route::get('/{activity}/show', [ActivityController::class, 'show'])->name('show');
        Route::get('/{day}/day', [ActivityController::class, 'day'])->name('day');
        Route::post('/ajax-delete-activity', [ActivityController::class, 'delete'])->name('ajax-delete-activity');
        Route::get('/search', [ActivityController::class, 'search'])->name('search');
        Route::get('/export', [ActivityController::class, 'export'])->name('export');
    });
});
