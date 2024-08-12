<?php

namespace Tests;

use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\BaseUri;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\Headers;
use Trukes\ThreadsApiPhpClient\DTO\Transporter\QueryParams;
use Trukes\ThreadsApiPhpClient\Exception\TransporterException;
use Trukes\ThreadsApiPhpClient\Exception\UnserializableResponse;
use Trukes\ThreadsApiPhpClient\Transporter;
use JsonException;

final class TransporterTest extends TestCase
{
    public function testTransporter(): void
    {
        $transporter = new Transporter(
            $clientMock = self::createMock(ClientInterface::class),
            $baseUri = BaseUri::from('http://example.com'),
            $headers = Headers::create(),
            $queryParams = QueryParams::create()->withParam('access_token', 'access-token-1')
        );

        $payload = Payload::create(
            'POST',
            'threads',
            ['hello' => 'world'],
            ['this_is_a_body' => 'with_content'],
            ['content/type' => 'json']
        );

        $response = self::createMock(ResponseInterface::class);

        $streamInterface = self::createMock(StreamInterface::class);
        $streamInterface->expects($this->once())
            ->method('getContents')
            ->willReturn(json_encode(['id' => 123]));

        $response
            ->expects(self::once())
            ->method('getBody')
            ->willReturn($streamInterface);

        $clientMock
            ->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(function ($request) use ($baseUri, $headers, $queryParams, $payload) {
                return $request->getMethod() === $payload->method()
                    && (string) $request->getUri() === (string) $payload->toRequest($baseUri, $headers, $queryParams)->getUri()
                    && $request->getHeaders() == $payload->toRequest($baseUri, $headers, $queryParams)->getHeaders();
            }))
            ->willReturn($response);

        self::assertEquals(
            Response::from(['id' => 123], []),
            $transporter->request($payload)
        );
    }

    public function testTransporterWithClientException(): void
    {
        $transporter = new Transporter(
            $clientMock = self::createMock(ClientInterface::class),
            $baseUri = BaseUri::from('http://example.com'),
            $headers = Headers::create(),
            $queryParams = QueryParams::create()->withParam('access_token', 'access-token-1')
        );

        $payload = Payload::create(
            'POST',
            'threads',
            ['hello' => 'world'],
            ['this_is_a_body' => 'with_content'],
            ['content/type' => 'json']
        );

        $response = self::createMock(ResponseInterface::class);
        $clientException = self::createMock(ClientException::class);

        $streamInterface = self::createMock(StreamInterface::class);
        $streamInterface->expects($this->once())
            ->method('getContents')
            ->willReturn(json_encode(['error' => 'Error']));

        $response
            ->expects(self::once())
            ->method('getBody')
            ->willReturn($streamInterface);

        $clientException
            ->expects(self::exactly(2))
            ->method('getResponse')
            ->willReturn($response);

        $clientMock
            ->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(function ($request) use ($baseUri, $headers, $queryParams, $payload) {
                return $request->getMethod() === $payload->method()
                    && (string) $request->getUri() === (string) $payload->toRequest($baseUri, $headers, $queryParams)->getUri()
                    && $request->getHeaders() == $payload->toRequest($baseUri, $headers, $queryParams)->getHeaders();
            }))
            ->willThrowException(
                $clientException
            );

        self::expectException(TransporterException::class);
        $transporter->request($payload);
    }

    public function testTransporterWithWrongJsonException(): void
    {
        {
            $transporter = new Transporter(
                $clientMock = self::createMock(ClientInterface::class),
                $baseUri = BaseUri::from('http://example.com'),
                $headers = Headers::create(),
                $queryParams = QueryParams::create()->withParam('access_token', 'access-token-1')
            );

            $payload = Payload::create(
                'POST',
                'threads',
                ['hello' => 'world'],
                ['this_is_a_body' => 'with_content'],
                ['content/type' => 'json']
            );

            $response = self::createMock(ResponseInterface::class);

            $streamInterface = self::createMock(StreamInterface::class);
            $streamInterface->expects($this->once())
                ->method('getContents')
                ->willReturn('this_is_not_an_json');

            $response
                ->expects(self::once())
                ->method('getBody')
                ->willReturn($streamInterface);

            $clientMock
                ->expects(self::once())
                ->method('sendRequest')
                ->with(self::callback(function ($request) use ($baseUri, $headers, $queryParams, $payload) {
                    return $request->getMethod() === $payload->method()
                        && (string) $request->getUri() === (string) $payload->toRequest($baseUri, $headers, $queryParams)->getUri()
                        && $request->getHeaders() == $payload->toRequest($baseUri, $headers, $queryParams)->getHeaders();
                }))
                ->willReturn($response);

            self::expectException(UnserializableResponse::class);
            $transporter->request($payload);
        }
    }

}