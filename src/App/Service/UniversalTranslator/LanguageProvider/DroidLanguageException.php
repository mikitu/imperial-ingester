<?php


namespace App\Service\UniversalTranslator\LanguageProvider;


class DroidLanguageException extends \Exception
{
    /**
     * DroidLanguageException constructor.
     */
    public function __construct()
    {
        parent::__construct('This is not a valid droid language');
    }
}