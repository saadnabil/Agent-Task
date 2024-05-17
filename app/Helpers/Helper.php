<?php

use App\Http\Resources\Api\CartResource;
use App\Models\Otp;
use Carbon\Carbon;

function resource_collection($resource): array
{
    return json_decode($resource->response()->getContent(), true) ?? [];
}

function langs(){
    return ['en', 'ar'];
}

function spin_game_array(){
    return [
        '1' => 'digit_one',
        '2' => 'digit_two',
        '3' => 'digit_three',
        '4' => 'digit_four',
        '5' => 'digit_five',
        '6' => 'digit_six',
        '7' => 'digit_seven',
        '8' => 'digit_eight',
        '9' => 'digit_nine',
    ];
}

function generate_otp_function(){
    return str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
}

function checkValidAppliedCouponBeforeSubmitOrder($coupon , $timezone){
    if($coupon == null){
        return true;
    }
    if ($coupon->expiration_date >= Carbon::now($timezone)->format('Y-m-d') && $coupon->status == 'pending') {
        return true;
    } else {
       return false;
    }
}





function get_day_calendar_index(){
    return [
        'Saturday' => 1,
        'Sunday' => 2,
        'Monday' => 3 ,
        'Tuesday' => 4,
        'Wednesday' => 5,
        'Thursday' => 6,
        'Friday' => 7
    ];
}

function create_new_otp($email , $code){
    Otp::where(['email' => $email])->delete();
    Otp::create([
        'email' => $email,
        'code' => $code,
    ]);
    return;
}

function weekDays (){
    return ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
}

