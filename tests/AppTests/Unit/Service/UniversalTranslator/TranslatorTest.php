<?php


namespace AppTests\Unit\Service\UniversalTranslator;


use App\Service\UniversalTranslator\LanguageProviderInterface;
use App\Service\UniversalTranslator\Translator;
use PHPUnit\Framework\TestCase;

class TranslatorTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_succesfully_execute_translate()
    {
        $text = 'I speak english';
        $expected = 'This is english';
        $language_provider = $this->getMockBuilder(LanguageProviderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $language_provider->method('translate')->willReturn($expected);
        $obj = new Translator($language_provider);
        self::assertEquals($expected, $obj->translate($text));
    }
}