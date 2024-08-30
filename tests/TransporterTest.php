<?php
declare(strict_types=1);

namespace Tests;

use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Trukes\ThreadsApiPhpClient\Exception\ErrorException;
use Trukes\ThreadsApiPhpClient\Exception\TransporterException;
use Trukes\ThreadsApiPhpClient\Exception\UnserializableResponse;
use Trukes\ThreadsApiPhpClient\Transporter\Transporter;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\AccessToken;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\BaseUri;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\BodyForm;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\Headers;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\QueryParams;
use Trukes\ThreadsApiPhpClient\ValueObject\Payload;
use Trukes\ThreadsApiPhpClient\ValueObject\Response;

final class TransporterTest extends TestCase
{
    public function testTransporter(): void
    {
        $transporter = new Transporter(
            $clientMock = self::createMock(ClientInterface::class),
            $baseUri = BaseUri::from('http://example.com'),
            $headers = Headers::create(),
            $queryParams = QueryParams::create(),
            $bodyForm = BodyForm::create(),
            $accessToken = AccessToken::from('access-token-1')
        );

        $payload = Payload::create(
            'POST',
            'threads',
            ['hello' => 'world'],
            ['this_is_a_body' => 'with_content']
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
            ->with(self::callback(function ($request) use ($baseUri, $accessToken, $headers, $queryParams, $bodyForm, $payload) {
                return $request->getMethod() === $payload->method()
                    && (string) $request->getUri() === (string) $payload->toRequest($baseUri, $accessToken, $headers, $queryParams, $bodyForm)->getUri()
                    && $request->getHeaders() == $payload->toRequest($baseUri, $accessToken, $headers, $queryParams, $bodyForm)->getHeaders();
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
            $queryParams = QueryParams::create(),
            $bodyForm = BodyForm::create(),
            $accessToken = AccessToken::from('access-token-1')
        );

        $payload = Payload::create(
            'POST',
            'threads',
            ['hello' => 'world'],
            ['this_is_a_body' => 'with_content'],
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
            ->with(self::callback(function ($request) use ($baseUri, $accessToken, $headers, $queryParams, $bodyForm, $payload) {
                return $request->getMethod() === $payload->method()
                    && (string) $request->getUri() === (string) $payload->toRequest($baseUri, $accessToken, $headers, $queryParams, $bodyForm)->getUri()
                    && $request->getHeaders() == $payload->toRequest($baseUri, $accessToken, $headers, $queryParams, $bodyForm)->getHeaders();
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
                $queryParams = QueryParams::create(),
                $bodyForm = BodyForm::create(),
                $accessToken = AccessToken::from('access-token-1')
            );

            $payload = Payload::create(
                'POST',
                'threads',
                ['hello' => 'world'],
                ['this_is_a_body' => 'with_content'],
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
                ->with(self::callback(function ($request) use ($baseUri, $accessToken, $headers, $queryParams, $bodyForm, $payload) {
                    return $request->getMethod() === $payload->method()
                        && (string) $request->getUri() === (string) $payload->toRequest($baseUri, $accessToken, $headers, $queryParams, $bodyForm)->getUri()
                        && $request->getHeaders() == $payload->toRequest($baseUri, $accessToken, $headers, $queryParams, $bodyForm)->getHeaders();
                }))
                ->willReturn($response);

            self::expectException(UnserializableResponse::class);
            $transporter->request($payload);
        }
    }

    public function testTransporterWithWrongJsonWithErrorException(): void
    {
        {
            $transporter = new Transporter(
                $clientMock = self::createMock(ClientInterface::class),
                $baseUri = BaseUri::from('http://example.com'),
                $headers = Headers::create(),
                $queryParams = QueryParams::create(),
                $bodyForm = BodyForm::create(),
                $accessToken = AccessToken::from('access-token-1')
            );

            $payload = Payload::create(
                'POST',
                'threads',
                ['hello' => 'world'],
                ['this_is_a_body' => 'with_content'],
            );

            $response = self::createMock(ResponseInterface::class);

            $streamInterface = self::createMock(StreamInterface::class);
            $streamInterface->expects($this->once())
                ->method('getContents')
                ->willReturn('this_is_not_an_json');

            $response
                ->expects(self::once())
                ->method('getHeaderLine')
                ->with('Content-Type')
                ->willReturn('application/json');

            $response
                ->expects(self::once())
                ->method('getStatusCode')
                ->willReturn(500);

            $response
                ->expects(self::once())
                ->method('getBody')
                ->willReturn($streamInterface);

            $clientMock
                ->expects(self::once())
                ->method('sendRequest')
                ->with(self::callback(function ($request) use ($baseUri, $accessToken, $headers, $queryParams, $bodyForm, $payload) {
                    return $request->getMethod() === $payload->method()
                        && (string) $request->getUri() === (string) $payload->toRequest($baseUri, $accessToken, $headers, $queryParams, $bodyForm)->getUri()
                        && $request->getHeaders() == $payload->toRequest($baseUri, $accessToken, $headers, $queryParams, $bodyForm)->getHeaders();
                }))
                ->willReturn($response);

            self::expectException(UnserializableResponse::class);
            $transporter->request($payload);
        }
    }

    public function testTransporterWithClientWithStatusCode500Exception(): void
    {
        $transporter = new Transporter(
            $clientMock = self::createMock(ClientInterface::class),
            $baseUri = BaseUri::from('http://example.com'),
            $headers = Headers::create(),
            $queryParams = QueryParams::create(),
            $bodyForm = BodyForm::create(),
            $accessToken = AccessToken::from('access-token-1')
        );

        $payload = Payload::create(
            'POST',
            'threads',
            ['hello' => 'world'],
            ['this_is_a_body' => 'with_content'],
        );

        $response = self::createMock(ResponseInterface::class);
        $clientException = self::createMock(ClientException::class);

        $streamInterface = self::createMock(StreamInterface::class);
        $streamInterface->expects($this->once())
            ->method('getContents')
            ->willReturn(
                json_encode(['error' => ['message' => 'Error', 'code' => 500]])
            );

        $response
            ->expects(self::once())
            ->method('getBody')
            ->willReturn($streamInterface);

        $response
            ->expects(self::once())
            ->method('getStatusCode')
            ->willReturn(500);

        $response
            ->expects(self::once())
            ->method('getHeaderLine')
            ->with('Content-Type')
            ->willReturn('application/json');

        $clientException
            ->expects(self::exactly(2))
            ->method('getResponse')
            ->willReturn($response);

        $clientMock
            ->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(function ($request) use ($baseUri, $accessToken, $headers, $queryParams, $bodyForm, $payload) {
                return $request->getMethod() === $payload->method()
                    && (string) $request->getUri() === (string) $payload->toRequest($baseUri, $accessToken, $headers, $queryParams, $bodyForm)->getUri()
                    && $request->getHeaders() == $payload->toRequest($baseUri, $accessToken, $headers, $queryParams, $bodyForm)->getHeaders();
            }))
            ->willThrowException($clientException);

        self::expectException(ErrorException::class);
        $transporter->request($payload);
    }

    public function testTransporterWithClientWithNoJsonTypeException(): void
    {
        $transporter = new Transporter(
            $clientMock = self::createMock(ClientInterface::class),
            $baseUri = BaseUri::from('http://example.com'),
            $headers = Headers::create(),
            $queryParams = QueryParams::create(),
            $bodyForm = BodyForm::create(),
            $accessToken = AccessToken::from('access-token-1')
        );

        $payload = Payload::create(
            'POST',
            'threads',
            ['hello' => 'world'],
            ['this_is_a_body' => 'with_content'],
        );

        $response = self::createMock(ResponseInterface::class);
        $clientException = self::createMock(ClientException::class);

        $streamInterface = self::createMock(StreamInterface::class);
        $streamInterface->expects($this->once())
            ->method('getContents')
            ->willReturn(json_encode(['error' => ['message' => 'Error', 'code' => 500]]));

        $response
            ->expects(self::once())
            ->method('getBody')
            ->willReturn($streamInterface);

        $response
            ->expects(self::once())
            ->method('getStatusCode')
            ->willReturn(500);

        $response
            ->expects(self::once())
            ->method('getHeaderLine')
            ->with('Content-Type')
            ->willReturn('none');

        $clientException
            ->expects(self::exactly(2))
            ->method('getResponse')
            ->willReturn($response);

        $clientMock
            ->expects(self::once())
            ->method('sendRequest')
            ->with(self::callback(function ($request) use ($baseUri, $accessToken, $headers, $queryParams, $bodyForm, $payload) {
                return $request->getMethod() === $payload->method()
                    && (string) $request->getUri() === (string) $payload->toRequest($baseUri, $accessToken, $headers, $queryParams, $bodyForm)->getUri()
                    && $request->getHeaders() == $payload->toRequest($baseUri, $accessToken, $headers, $queryParams, $bodyForm)->getHeaders();
            }))
            ->willThrowException($clientException);

        self::expectException(TransporterException::class);
        $transporter->request($payload);
    }
}