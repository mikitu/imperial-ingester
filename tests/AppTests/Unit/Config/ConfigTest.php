<?php

namespace AppTests\Unit\Config;


use App\Config\Config;
use App\Config\YamlParser;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_create_object()
    {
        $obj = new Config(__DIR__.'/../../testdata/config_test.yaml', new YamlParser());
        self::assertEquals(123, $obj->get('test'));
    }

    /**
     * @test
     */
    public function it_should_throw_exception_if_invalid_file_path_provided()
    {
        self::expectException(\App\Config\FileNotFoundException::class);
        new Config('fake_file.yaml', new YamlParser());
    }
}