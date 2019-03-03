<?php


namespace AppTests\Unit\Service\UniversalTranslator\LanguageProvider;


use App\Service\UniversalTranslator\LanguageProvider\DroidLanguageException;
use App\Service\UniversalTranslator\LanguageProvider\DroidSpeak;
use PHPUnit\Framework\TestCase;

class DroidSpeakTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_successfully_translate_text()
    {
        $lang = new DroidSpeak();
        $expected = <<<EOF
{"cell":"Cell 2187","block":"Detention Block AA-23,"}
EOF;

        $result = $lang->translate(
<<<EOF
{
    "cell": "01000011 01100101 01101100 01101100 00100000 00110010 00110001 00111000 00110111",
    "block": "01000100 01100101 01110100 01100101 01101110 01110100 01101001 01101111 01101110 00100000 01000010 01101100 01101111 01100011 01101011 00100000 01000001 01000001 00101101 00110010 00110011 00101100"
}
EOF
        );
        self::assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_for_unknown_language()
    {
        $lang = new DroidSpeak();
        self::expectException(DroidLanguageException::class);
        $lang->translate('bad_json');
    }
}