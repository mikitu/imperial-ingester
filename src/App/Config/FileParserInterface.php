<?php

namespace App\Config;


interface FileParserInterface
{
    /**
     * @param $resource
     * @return mixed
     */
    public function parse($resource);
}