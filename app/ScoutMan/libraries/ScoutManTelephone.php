<?php
/**
 * Created by PhpStorm.
 * User: Jake
 * Date: 22/05/2015
 * Time: 21:42
 */

namespace Helpers;


class ScoutManTelephone {

    public static function format($in){

        //remove all but numbers
        $out = preg_replace("/[^0-9]/", '', $in);

        //remove the leading zero, and replace with 44
        if(substr($out, 0, 1) == '0'){
            $out = '44' . substr($out, 1);
        }

        return $out;
    }

    /**
     * Takes a formatted number (from the format function
     * Checks if it looks like a valid mobile number.
     * (Starts with 447, and is 12 digits long)
     *
     * @param $in
     * @return bool
     */
    public static function isMobile($in){

        if(substr($in, 0, 3) == '447'){
            if(strlen($in) == 12) {
                return true;
            }
        }

        return false;

    }

}