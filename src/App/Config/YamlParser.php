<?php

namespace App\Config;


use Symfony\Component\Yaml\Yaml;

class YamlParser implements FileParserInterface
{

    /**
     * @param $resource
     * @return mixed
     */
    public function parse($resource)
    {
        return Yaml::parse($resource);
    }
}