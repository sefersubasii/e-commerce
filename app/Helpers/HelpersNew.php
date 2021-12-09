<?php

namespace App\Helpers;

use Carbon\Carbon;

class HelpersNew
{

    public static function productCntrlDiscount($discountFinishDate)
    {
        if ($discountFinishDate != null) {
            $todayDate   = Carbon::now()->toDateTimeString();
            $oldDiscount = false;
            if (strtotime($todayDate) >= strtotime($discountFinishDate)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;

        }
    }
    public static function codeControl($code)
    {
        if (count(\App\Products::where('stock_code', '=', $code)->get()) > 1) {
            return true;
        } else {
            return false;
        }
    }
    public static function discountControl($discountStartDate, $discountFinishDate, $discounttype)
    {
        if (!empty($discountFinishDate) && !empty($discountStartDate)) {
            $todayDate = Carbon::now()->toDateTimeString();
            if (strtotime($todayDate) >= strtotime($discountStartDate) && strtotime($todayDate) >= strtotime($discountFinishDate) && $discounttype > 0) {
                return true;
            } else if (strtotime($todayDate) <= strtotime($discountStartDate) && $discounttype > 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;

        }

    }
    public static function discountTrueFalse()
    {
        $data  = \App\Settings_basic::find(1);
        $basic = json_decode($data->basic);

        if (isset($basic->discountdate_status)) {
            return $basic->discountdate_status;
        }

        return false;
    }

    public static function prdctDiscountDateCntrl($product)
    {
        if (HelpersNew::discountTrueFalse() && !empty($product->discount_start_date)) {
            $todayDate = Carbon::now()->toDateTimeString();
            if (!empty($product)) {
                if (strtotime($todayDate) >= strtotime($product->discount_start_date) && strtotime($todayDate) >= strtotime($product->discount_finish_date) && $product->discount_type > 0) {
                    $product->discount_type = 0;
                    return $product;
                } else if (strtotime($todayDate) <= strtotime($product->discount_start_date) && $product->discount_type > 0) {
                    $product->discount_type = 0;
                    return $product;
                } else {
                    return $product;
                }
            } else {
                return $product;
            }
        } else {
            return $product;
        }

    }

}
