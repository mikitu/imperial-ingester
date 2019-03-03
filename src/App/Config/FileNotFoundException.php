<?php

namespace App\Config;


class FileNotFoundException extends \Exception
{
    /**
     * FileNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct("config file not found");
    }
}