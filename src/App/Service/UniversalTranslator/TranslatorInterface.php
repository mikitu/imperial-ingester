<?php
namespace App\Service\UniversalTranslator;

interface TranslatorInterface
{
    /**
     * @param string $text
     * @return string
     */
    public function translate(string $text):string;
}