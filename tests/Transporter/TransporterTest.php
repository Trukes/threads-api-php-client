<?php
declare(strict_types=1);

namespace Tests\Transporter;

use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Trukes\ThreadsApiPhpClient\Exception\ErrorException;
use Trukes\ThreadsApiPhpClient\Exception\TransporterException;
use Trukes\ThreadsApiPhpClient\Exception\UnserializableResponse;
use Trukes\ThreadsApiPhpClient\Transporter\Transporter;
use Trukes\ThreadsApiPhpClient\Transporter\TransporterInterface;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\AccessToken;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\BaseUri;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\Headers;
use Trukes\ThreadsApiPhpClient\ValueObject\Payload;
use Trukes\ThreadsApiPhpClient\ValueObject\Response;

final class TransporterTest extends TestCase
{
    protected TransporterInterface $transporter;
    protected MockObject|ClientInterface $clientMock;
    protected MockObject|ResponseInterface $response;
    protected MockObject|StreamInterface $stream;

    protected BaseUri $baseUri;
    protected Headers $headers;
    protected AccessToken $accessToken;
    protected Payload $payload;


    public function testTransporter(): void
    {
        $this->streamInterface->expects($this->once())
            ->method('getContents')
            ->willReturn(json_encode(['id' => 123]));

        $this->response
            ->expects(self::once())
            ->method('getBody')
            ->willReturn($this->streamInterface);

        $this->clientMock
            ->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(function ($request) {
                return $request->getMethod() === $this->payload->method()
                    && (string)$request->getUri() === (string)$this->payload->toRequest($this->baseUri, $this->accessToken, $this->headers)->getUri()
                    && $request->getHeaders() == $this->payload->toRequest($this->baseUri, $this->accessToken, $this->headers)->getHeaders();
            }))
            ->willReturn($this->response);

        self::assertEquals(
            Response::from(['id' => 123], []),
            $this->transporter->request($this->payload)
        );
    }

    public function testTransporterWithClientException(): void
    {
        $clientException = self::createMock(ClientException::class);

        $this->streamInterface->expects($this->once())
            ->method('getContents')
            ->willReturn(json_encode(['error' => 'Error']));

        $this->response
            ->expects(self::once())
            ->method('getBody')
            ->willReturn($this->streamInterface);

        $clientException
            ->expects(self::exactly(2))
            ->method('getResponse')
            ->willReturn($this->response);

        $this->clientMock
            ->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(function ($request) {
                return $request->getMethod() === $this->payload->method()
                    && (string)$request->getUri() === (string)$this->payload->toRequest($this->baseUri, $this->accessToken, $this->headers)->getUri()
                    && $request->getHeaders() == $this->payload->toRequest($this->baseUri, $this->accessToken, $this->headers)->getHeaders();
            }))
            ->willThrowException(
                $clientException
            );

        self::expectException(TransporterException::class);
        $this->transporter->request($this->payload);
    }

    public function testTransporterWithWrongJsonException(): void
    {
        $this->streamInterface->expects($this->once())
            ->method('getContents')
            ->willReturn('this_is_not_an_json');

        $this->response
            ->expects(self::once())
            ->method('getBody')
            ->willReturn($this->streamInterface);

        $this->clientMock
            ->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(function ($request) {
                return $request->getMethod() === $this->payload->method()
                    && (string)$request->getUri() === (string)$this->payload->toRequest($this->baseUri, $this->accessToken, $this->headers)->getUri()
                    && $request->getHeaders() == $this->payload->toRequest($this->baseUri, $this->accessToken, $this->headers)->getHeaders();
            }))
            ->willReturn($this->response);

        self::expectException(UnserializableResponse::class);
        $this->transporter->request($this->payload);

    }

    public function testTransporterWithWrongJsonWithErrorException(): void
    {
        $this->streamInterface->expects(self::once())
            ->method('getContents')
            ->willReturn('this_is_not_an_json');

        $this->response
            ->expects(self::once())
            ->method('getHeaderLine')
            ->with('Content-Type')
            ->willReturn('application/json');

        $this->response
            ->expects(self::once())
            ->method('getStatusCode')
            ->willReturn(500);

        $this->response
            ->expects(self::once())
            ->method('getBody')
            ->willReturn($this->streamInterface);

        $this->clientMock
            ->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(function ($request){
                return $request->getMethod() === $this->payload->method()
                    && (string)$request->getUri() === (string)$this->payload->toRequest($this->baseUri, $this->accessToken, $this->headers)->getUri()
                    && $request->getHeaders() == $this->payload->toRequest($this->baseUri, $this->accessToken, $this->headers)->getHeaders();
            }))
            ->willReturn($this->response);

        self::expectException(UnserializableResponse::class);
        $this->transporter->request($this->payload);

    }

    public function testTransporterWithClientWithStatusCode500Exception(): void
    {
        $clientException = self::createMock(ClientException::class);

        $this->streamInterface->expects(self::once())
            ->method('getContents')
            ->willReturn(
                json_encode(['error' => ['message' => 'Error', 'code' => 500]])
            );

        $this->response
            ->expects(self::once())
            ->method('getBody')
            ->willReturn($this->streamInterface);

        $this->response
            ->expects(self::once())
            ->method('getStatusCode')
            ->willReturn(500);

        $this->response
            ->expects(self::once())
            ->method('getHeaderLine')
            ->with('Content-Type')
            ->willReturn('application/json');

        $clientException
            ->expects(self::exactly(2))
            ->method('getResponse')
            ->willReturn($this->response);

        $this->clientMock
            ->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(function ($request){
                return $request->getMethod() === $this->payload->method()
                    && (string)$request->getUri() === (string)$this->payload->toRequest($this->baseUri, $this->accessToken, $this->headers)->getUri()
                    && $request->getHeaders() == $this->payload->toRequest($this->baseUri, $this->accessToken, $this->headers)->getHeaders();
            }))
            ->willThrowException($clientException);

        self::expectException(ErrorException::class);
        $this->transporter->request($this->payload);
    }

    public function testTransporterWithClientWithNoJsonTypeException(): void
    {
        $clientException = self::createMock(ClientException::class);

        $this->streamInterface->expects(self::once())
            ->method('getContents')
            ->willReturn(json_encode(['error' => ['message' => 'Error', 'code' => 500]]));

        $this->response
            ->expects(self::once())
            ->method('getBody')
            ->willReturn($this->streamInterface);

        $this->response
            ->expects(self::once())
            ->method('getStatusCode')
            ->willReturn(500);

        $this->response
            ->expects(self::once())
            ->method('getHeaderLine')
            ->with('Content-Type')
            ->willReturn('none');

        $clientException
            ->expects(self::exactly(2))
            ->method('getResponse')
            ->willReturn($this->response);

        $this->clientMock
            ->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(function ($request){
                return $request->getMethod() === $this->payload->method()
                    && (string)$request->getUri() === (string)$this->payload->toRequest($this->baseUri, $this->accessToken, $this->headers)->getUri()
                    && $request->getHeaders() == $this->payload->toRequest($this->baseUri, $this->accessToken, $this->headers)->getHeaders();
            }))
            ->willThrowException($clientException);

        self::expectException(TransporterException::class);
        $this->transporter->request($this->payload);
    }


    protected function setUp(): void
    {
        $this->transporter = new Transporter(
            $this->clientMock = self::createMock(ClientInterface::class),
            $this->baseUri = BaseUri::from('http://example.com'),
            $this->headers = Headers::create(),
            $this->accessToken = AccessToken::from('access-token-1')
        );

        $this->payload = Payload::create(
            'POST',
            'threads',
            ['hello' => 'world'],
            ['this_is_a_body' => 'with_content'],
        );

        $this->response = self::createMock(ResponseInterface::class);

        $this->streamInterface = self::createMock(StreamInterface::class);
    }
}