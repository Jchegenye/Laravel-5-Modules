<?php 

namespace App\ReusableCodes {

    /**
     * @author Jackson Asumu Chegenye
     *         0711494289
     *         chegenyejackson@gmail.com
     * @version 0.0.1
     * @copyright 2015-2017 j-tech.tech
     *
     * @File Handles Verification Code generation
     */

    class GenerateVerificationCode{
        /**
         * Returns an new verify code. For every subscriber
         *
         * @return string
         */
        public static function generateVerifyCode($code)
        {
            $code =  "laravel5modules" . str_random(42) . date('M,Y');
            return $code;
        }

        /**
         *
         * @param $code
         * @return string
         */
        public static function generatePermissionsCode($code)
        {
            $code =  str_random(10);
            return $code;
        }
    }
}