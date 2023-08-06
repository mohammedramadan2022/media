<?php

namespace App\Http\Traits\Callbacks;

use App\Models\{Admin, Advance, Contact, Demand, Notification, Order, Product, Throwback, Vacation};

trait AppCallbacks
{
    // Shared Variables;
    public static function getAuth(): callable
    {
        return fn ($view) => $view->with('auth', request()->user());
    }

    public static function getNewMessages(): callable
    {
        return fn ($view) => $view->with('newMessagesCount', Contact::whereIsSeen(0)->count());
    }

    public static function getNewNotifications(): callable
    {
        return fn ($view) => $view->with('newNotificationsCount', Notification::whereIsSeen(0)->where('notificationable_type', Admin::class)->count());
    }

    public static function getNewProducts(): callable
    {
        return fn ($view) => $view->with('newProductsCount', Product::whereNull('is_accepted')->count());
    }

    public static function getNewDemands(): callable
    {
        return fn ($view) => $view->with('newDemandsCount', Demand::whereNull('is_accepted')->count());
    }

    public static function getNewOrders(): callable
    {
        return fn ($view) => $view->with('newOrdersCount', Order::query()->whereNull('is_rental_accept')->pending()->count());
    }

    public static function getNewVacations(): callable
    {
        return fn ($view) => $view->with('newVacationsCount', Vacation::whereNull('is_accepted')->count());
    }

    public static function getNewAdvances(): callable
    {
        return fn ($view) => $view->with('newAdvancesCount', Advance::whereNull('is_accepted')->count());
    }

    public static function getNewThrowbacks(): callable
    {
        return fn ($view) => $view->with('newThrowbacksCount', Throwback::whereNull('status')->count());
    }
}
