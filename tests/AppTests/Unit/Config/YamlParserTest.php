<?php

namespace AppTests\Unit\Config;


use App\Config\YamlParser;
use PHPUnit\Framework\TestCase;

class YamlParserTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_successfully_parse_yaml()
    {
        $parser = new YamlParser();
        $yaml = <<<EOF
test: 1234
test2: 12345
EOF;
        $data = $parser->parse($yaml);
        self::assertEquals(['test' => 1234, 'test2' => 12345], $data);
    }
}