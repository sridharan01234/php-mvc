<?php

class BaseController
{
    /**
     * Error logger
     *
     * @param string $log
     * @return void
     */
    public function logger(string $log): void
    {
        error_log($log);
    }

        /**
     * Error logger
     *
     * @param string $log
     * @return void
     */
    final public function log(string $log): void
    {
        error_log($log);
    }
}
