<?php


namespace App\Service\Api;


use App\Http\Oauth2ClientInterface;
use App\Service\UniversalTranslator\Translator;
use App\Service\UniversalTranslator\TranslatorInterface;

class Consumer implements ConsumerInterface
{
    /**
     * @var Oauth2ClientInterface
     */
    private $client;

    /**
     * Consumer constructor.
     * @param Oauth2ClientInterface $client
     */
    public function __construct(Oauth2ClientInterface $client)
    {
        $this->client = $client;
    }


    /**
     * @param int $exhaust_id
     * @return bool
     */
    public function deleteExhaust(int $exhaust_id): bool
    {
        $response = $this->client->delete('/reactor/exhaust/' . $exhaust_id);
        if ($response->getStatusCode() !== 200) {
            return false;
        }
        return true;
    }

    /**
     * @param string $prisoner_name
     * @param Translator $translator
     * @return array
     */
    public function getPrisoner(string $prisoner_name, TranslatorInterface $translator): array
    {
        $response = $this->client->get('/prisoner/' . $prisoner_name);
        $translatedResponse = $translator->translate($response->getBody());
        return json_decode($translatedResponse, true);
    }
}