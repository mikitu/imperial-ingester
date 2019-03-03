<?php


namespace App\Service\Api;


use App\Service\UniversalTranslator\TranslatorInterface;

interface ConsumerInterface
{
    /**
     * @param int $exhaust_id
     * @return bool
     */
    public function deleteExhaust(int $exhaust_id):bool;

    /**
     * @param string $prisoner_name
     * @param TranslatorInterface $translator
     * @return array
     */
    public function getPrisoner(string $prisoner_name, TranslatorInterface $translator):array;
}