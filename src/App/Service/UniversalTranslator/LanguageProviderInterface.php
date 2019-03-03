<?php


namespace App\Service\UniversalTranslator;


interface LanguageProviderInterface
{
    /**
     * @param string $text
     * @return string
     */
    public function translate(string $text): string;
}