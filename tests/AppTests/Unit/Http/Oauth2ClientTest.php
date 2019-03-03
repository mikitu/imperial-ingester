<?php


namespace AppTests\Unit\Http;


use App\Config\ConfigInterface;
use App\Http\AuthException;
use App\Http\Oauth2Client;
use App\Http\Oauth2ClientInterface;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class Oauth2ClientTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_create_object()
    {
        $oauth2Client = $this->getMockObject();
        self::assertInstanceOf(Oauth2ClientInterface::class, $oauth2Client);
    }

    /**
     * @test
     */
    public function it_should_return_a_valid_response_for_post_request()
    {
        $body = <<<EOF
{
    "access_token": "e31a726c4b90462ccb7619e1b51f3d0068bf8006",
    "expires_in": 99999999999,
    "token_type": "Bearer",
    "scope": "TheForce"
}
EOF;

        $oauth2Client = $this->getMockObject(200, $body);
        $response = $oauth2Client->token();
        self::assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_should_throw_exception_for_bad_http_status()
    {
        $oauth2Client = $this->getMockObject(500);
        self::expectException(AuthException::class);
        self::expectExceptionMessage('Cannot access auth server');
        $oauth2Client->get('/some/invalid/endpoint');
    }

    /**
     * @test
     */
    public function it_should_throw_exception_for_bad_response()
    {
        $body = 'bad json';
        $oauth2Client = $this->getMockObject(200, $body);
        self::expectException(AuthException::class);
        self::expectExceptionMessage('Bad response from auth server');
        $oauth2Client->get('/some/invalid/endpoint');
    }

    /**
     * @test
     */
    public function it_should_throw_exception_if_missing_access_token()
    {
        $body = '{"bad": "json"}';
        $oauth2Client = $this->getMockObject(200, $body);
        self::expectException(AuthException::class);
        self::expectExceptionMessage('The auth server didn\'t return an access_token');
        $oauth2Client->get('/some/valid/endpoint');
    }

    /**
     * @test
     */
    public function it_should_return_a_valid_response_for_get_request()
    {
        $body = <<<EOF
{
    "access_token": "e31a726c4b90462ccb7619e1b51f3d0068bf8006",
    "expires_in": 99999999999,
    "token_type": "Bearer",
    "scope": "TheForce"
}
EOF;
        $oauth2Client = $this->getMockObject(200, $body);
        $response = $oauth2Client->get('/some/valid/endpoint');
        self::assertEquals(200, $response->getStatusCode());
    }

    /**
     * @test
     */
    public function it_should_return_a_valid_response_for_delete_request()
    {
        $body = <<<EOF
{
    "access_token": "e31a726c4b90462ccb7619e1b51f3d0068bf8006",
    "expires_in": 99999999999,
    "token_type": "Bearer",
    "scope": "TheForce"
}
EOF;

        $oauth2Client = $this->getMockObject(200, $body);
        $response = $oauth2Client->delete('/some/valid/endpoint');
        self::assertEquals(200, $response->getStatusCode());
    }

    /**
     * @return Oauth2Client
     * @throws \ReflectionException
     */
    private function getMockObject($resp_status_code = 200, $resp_body = ''): Oauth2Client
    {
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $response->method('getStatusCode')->willReturn($resp_status_code);
        $response->method('getBody')->willReturn($resp_body);
        $http_client = $this->getMockBuilder(ClientInterface::class)->getMock();
        $http_client->method('request')->willReturn($response);
        $config = $this->getMockBuilder(ConfigInterface::class)->getMock();
        $oauth2Client = new Oauth2Client($http_client, $config);
        return $oauth2Client;
    }

}