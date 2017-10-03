<?php 

namespace App\ReusableCodes {

    /**
     * @author Jackson Asumu Chegenye
     *         0711494289
     *         chegenyejackson@gmail.com
     * @version 0.0.1
     * @copyright 2015-2017 j-tech.tech
     *
     * @File Handles Dates
     */

    class DateFormats {
        /**
         * Here, we set all our date formats and return.
         * @return variable out of it
         **/
        public function date(){

            $date = array(
                'Date1' => date('M d, Y'),
                'DateTime2' => date('D, d-M-y H:i T'),
            );

            return $date;
        }
    }
}