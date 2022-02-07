<?php

namespace App\Helpers;

use App\Notifications\ContactUs;
use App\Notifications\PlaceOrderStatus;
use App\Notifications\PlaceOrderSuccess;
use App\Notifications\UserRegistration;
use Notification;
use Log;

class NotificationHelper
{

    public static function placeOrderSuccess($order)
    {
        $user = $order->user;
        try {
            $user->notify(new PlaceOrderSuccess($order));
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
    public static function placeOrderStatus($order, $orderDetail, $status)
    {
        $user = $order->user;
        try {
            $user->notify(new PlaceOrderStatus($order, $orderDetail, $status));
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public static function userRegister($user)
    {
        try {
            $user->notify(new UserRegistration($user));
        } catch (\Exception $e) {
            Log::error($e);
        }
    }

    public static function contactUs($contact)
    {
        try {
            $contact->notify(new ContactUs($contact));
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
