<?php


namespace App\Service\UniversalTranslator;


class Translator implements TranslatorInterface
{
    /**
     * @var LanguageProviderInterface
     */
    private $language_provider;

    /**
     * Translator constructor.
     * @param LanguageProviderInterface $language_provider
     */
    public function __construct(LanguageProviderInterface $language_provider)
    {

        $this->language_provider = $language_provider;
    }

    /**
     * translate given text in given language into plain english
     * @param string $text
     * @return string
     */
    public function translate(string $text): string
    {
        return $this->language_provider->translate($text);
    }
}