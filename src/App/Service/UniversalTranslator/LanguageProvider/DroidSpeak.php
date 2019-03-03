<?php


namespace App\Service\UniversalTranslator\LanguageProvider;


use App\Service\UniversalTranslator\LanguageProviderInterface;

class DroidSpeak implements LanguageProviderInterface
{

    /**
     * @param string $text json string
     * @return string json encoded
     * @throws DroidLanguageException
     */
    public function translate(string $text): string
    {
        $json = json_decode(trim($text), true);
        if (!$json) {
            throw new DroidLanguageException();
        }
        foreach ($json as &$value) {
            $value = $this->binToChar(explode(' ', $value));
        }
        return json_encode($json);
    }

    /**
     * @param array $digits
     * @return string
     */
    private function binToChar(array $digits) : string
    {
        array_walk($digits, function(&$item) {
            $item = chr((int)bindec($item));
        });
        return implode('', $digits);
    }
}