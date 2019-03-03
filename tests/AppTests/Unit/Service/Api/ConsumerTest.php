<?php


namespace AppTests\Unit\Service\Api;


use App\Http\Oauth2ClientInterface;
use App\Service\Api\Consumer;
use App\Service\Api\ConsumerInterface;
use App\Service\UniversalTranslator\TranslatorInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;

class ConsumerTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_create_object()
    {
        $client = $this->getClientMock();
        $obj = new Consumer($client);
        self::assertInstanceOf(ConsumerInterface::class, $obj);
    }

    /**
     * @test
     */
    public function it_should_successfully_delete_exhaust()
    {
        $client = $this->getClientMock();
        $consumer = new Consumer($client);
        self::assertTrue($consumer->deleteExhaust(123));
    }

    /**
     * @test
     */
    public function it_should_not_delete_exhaust()
    {
        $client = $this->getClientMock(500);
        $consumer = new Consumer($client);
        self::assertFalse($consumer->deleteExhaust(123));
    }

    /**
     * @test
     */
    public function it_should_successfully_get_prisoner_data()
    {
        $client = $this->getClientMock();
        $interpretor = $this->getMockBuilder(TranslatorInterface::class)
            ->disableOriginalConstructor()->getMock();
        $interpretor->method('translate')->withAnyParameters()->willReturn(
            json_encode(['Hello' => 'Droids'])
        );
        $consumer = new Consumer($client);
        $prisoner = $consumer->getPrisoner('leia', $interpretor);
        self::assertSame(['Hello' => 'Droids'], $prisoner);
    }

    /**
     * @param int $statusCode
     * @return MockObject
     * @throws ReflectionException
     */
    private function getClientMock($statusCode = 200) : MockObject
    {
        $response = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $response->expects(self::any())->method('getStatusCode')->willReturn($statusCode);
        $response->method('getBody')->willReturn('some response');
        $client = $this->getMockBuilder(Oauth2ClientInterface::class)->disableOriginalConstructor()->getMock();
        $client->method('get')->willReturn($response);
        $client->method('delete')->willReturn($response);
        return $client;
    }
}