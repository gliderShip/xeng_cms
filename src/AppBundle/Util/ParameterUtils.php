<?php
namespace AppBundle\Util;

class ParameterUtils {

    /**
     * replaces dots on a parameter name with percentages
     * @param string $param
     * @return string
     */
    public static function encodePeriods($param) {
        return str_replace('.','%',$param);
    }

    /**
     * replaces percentages on a parameter name with dots
     * @param string $param
     * @return string
     */
    public static function decodePeriods($param) {
        return str_replace('%','.',$param);
    }

}
