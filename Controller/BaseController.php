<?php

abstract class BaseController {
    /**
     * Error logger
     * 
     * @param string $log
     * @return void
     */
    abstract public function logger(string $log):void;
}