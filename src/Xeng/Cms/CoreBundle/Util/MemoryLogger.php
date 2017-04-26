<?php
namespace Xeng\Cms\CoreBundle\Util;

class MemoryLogger {
    static $logs=array();

    /**
     * adds log
     * @param mixed $log
     */
    public static function log($log) {
        self::$logs[]=$log;
    }

    /**
     * get logs
     */
    public static function getLogs() {
        return self::$logs;
    }

}