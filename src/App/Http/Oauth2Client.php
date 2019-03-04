<?php


namespace App\Http;


use App\Config\ConfigInterface;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use App\Config\Config;
use Psr\Http\Message\ResponseInterface;

class Oauth2Client implements Oauth2ClientInterface
{
    /**
     * @var ClientInterface
     */
    private $http_client;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var string
     */
    private $access_token;

    /**
     * Oauth2Client constructor.
     * @param ClientInterface $http_client
     * @param Config $config
     */
    public function __construct(ClientInterface $http_client, ConfigInterface $config)
    {
        $this->http_client = $http_client;
        $this->config = $config;
    }

    /**
     * @param string $endpoint
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws AuthException
     */
    public function get(string $endpoint) : ResponseInterface
    {
        return $this->getAuthClient()->request('GET', $endpoint, [
            RequestOptions::CERT => [
                $this->config->get('ssl_cert_path'),
                $this->config->get('ssl_cert_pass'),
            ],
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $this->access_token,
                'ContentType'   => 'application/json',
            ]
        ]);
    }

    /**
     * @param string $endpoint
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws AuthException
     */
    public function delete(string $endpoint) : ResponseInterface
    {
        return $this->getAuthClient()->request('DELETE', $endpoint, [
            RequestOptions::CERT => [
                $this->config->get('ssl_cert_path'),
                $this->config->get('ssl_cert_pass'),
            ],
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $this->access_token,
                'ContentType'   => 'application/json',
                'x-torpedoes'   => '2',
            ]
        ]);
    }

    /**
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function token() : ResponseInterface
    {
        return $this->http_client->request('POST', '/token',
            [
                RequestOptions::CERT => [
                    $this->config->get('ssl_cert_path'),
                    $this->config->get('ssl_cert_pass'),
                ],
                RequestOptions::AUTH => [
                    $this->config->get('client_id'),
                    $this->config->get('client_secret'),
                ],
                RequestOptions::HEADERS => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                RequestOptions::FORM_PARAMS => [
                    'grant_type' => 'client_credentials',
                ]
            ]
        );
    }

    /**
     * @return Oauth2Client
     * @throws GuzzleException
     * @throws AuthException
     */
    private function authenticate() : Oauth2Client
    {
        $response = $this->token();
        if ($response->getStatusCode() != 200) {
            throw new AuthException('Cannot access auth server', $response->getStatusCode());
        }
        $body = $response->getBody();
        $json = json_decode($body, true);
        if (!$json) {
            throw new AuthException('Bad response from auth server');
        }
        $this->access_token = $json['access_token'] ?? null;
        if (!$this->access_token) {
            throw new AuthException('The auth server didn\'t return an access_token');
        }
        return $this;

    }

    /**
     * @return ClientInterface
     * @throws GuzzleException
     * @throws AuthException
     */
    private function getAuthClient() : ClientInterface
    {
        $this->authenticate();
        return $this->http_client;
    }
}
