<?php

abstract class BaseController {
    /**
     * Error logger
     * 
     * @param string $log
     * @return void
     */
     public function logger(string $log):void
     {
        error_log($log);
     }
}