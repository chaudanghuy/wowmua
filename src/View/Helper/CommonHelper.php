<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Mailgun\Mailgun;

class CommonHelper extends Helper {

    public function getCartInfoByUserId($id) {
        $carts = TableRegistry::get("Carts")->find('all', [
            'conditions' => ['Carts.user_id' => $id, 'Carts.status' => 1],
            'contain' => ['Products']
        ]);
        return $carts;
    }

    public function getProductInfoByProductId($id) {
        $product = TableRegistry::get("Products")->find('all', [
            'conditions' => ['Products.id' => $id]
        ]);

        return $product->first();
    }

    public function makeSlug($str) {
        $str = trim(mb_strtolower($str, "utf8"));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = str_replace(' - ', ' ', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return $str;
    }

    function getDiffTime($created_time) {
        $time_ago = strtotime($created_time);
        $current_time = time();
        $time_difference = $current_time - $time_ago;
        $seconds = $time_difference;
        $minutes = round($seconds / 60);           // value 60 is seconds
        $hours = round($seconds / 3600);           //value 3600 is 60 minutes * 60 sec
        $days = round($seconds / 86400);          //86400 = 24 * 60 * 60;
        $weeks = round($seconds / 604800);          // 7*24*60*60;
        $months = round($seconds / 2629440);     //((365+365+365+365+366)/5/12)*24*60*60
        $years = round($seconds / 31553280);     //(365+365+365+365+366)/5 * 24 * 60 * 60
        if ($seconds <= 60) {
            return "bây giờ";
        } else if ($minutes <= 60) {
            if ($minutes == 1) {
                return "một phút trước";
            } else {
                return "$minutes phút trước";
            }
        } else if ($hours <= 24) {
            if ($hours == 1) {
                return "một giờ trước";
            } else {
                return "$hours giờ trước";
            }
        } else if ($days <= 7) {
            if ($days == 1) {
                return "hôm qua";
            } else {
                return "$days ngày trước";
            }
        } else if ($weeks <= 4.3) { //4.3 == 52/12
            if ($weeks == 1) {
                return "một tuần trước";
            } else {
                return "$weeks tuần trước";
            }
        } else if ($months <= 12) {
            if ($months == 1) {
                return "một tháng trước";
            } else {
                return "$months tháng trước";
            }
        } else {
            if ($years == 1) {
                return "một năm trước";
            } else {
                return "$years năm trước";
            }
        }
    }

    function getCurrency($country = '') {
        $currency = "VNĐ";
        if ($country == "HÀN QUỐC") {
            $currency = "KRW";
        } else if ($country == "ÚC") {
            $currency = "AUD";
        } else if ($country == "NHẬT BẢN") {
            $currency = "JPY";
        } else if ($country == "ANH") {
            $currency = "GPB";
        } else if ($country == "PHÁP") {
            $currency = "EUR";
        } else if ($country == "ĐỨC") {
            $currency = "EUR";
        }

        return $currency;
    }

    public function calcPrice($price, $from_location, $local_ship, $weight, $qty = 1) {
        $currency = 0;

        if ($from_location == "ÚC") {
            $currency = 18000;
        } else if ($from_location == "NHẬT BẢN") {
            $currency = 220;
        } else if ($from_location == "HÀN QUỐC") {
            $currency = 22;
        }

        if ($currency == 0) {
            return false;
        }


        // Giá SP
        $itemPrice = $price * $currency;

        // Ship nội địa
        $localShip = $local_ship * $currency;

        // Service fee
        $serviceFee = 30000;

        $totalPrice = 0;
        // $weight = (!$weight) ? 1 : $weight;

        $transportFee = 0;
        if ($from_location == "ÚC") {
            // Tiền mua hộ & vận chuyển
            $transportFee = ($weight + 0.2) * 250000;
            if ($transportFee < 100000) {
                $transportFee = 100000;
            }
        } else if ($from_location == "NHẬT BẢN") {
            // Tiền mua hộ & vận chuyển
            $transportFee = ($weight + 0.2) * 230000;
            if ($transportFee < 100000) {
                $transportFee = 100000;
            }
        } else if ($from_location == "HÀN QUỐC") {
            // Tiền mua hộ & vận chuyển
            $transportFee = ($weight + 0.2) * 200000;
            if ($transportFee < 80000) {
                $transportFee = 80000;
            }
        }

        $totalPrice = ($itemPrice + $localShip + $transportFee) * 1.08 + $serviceFee;

        $totalPrice = $totalPrice * $qty;

        return number_format($totalPrice);
    }
}
