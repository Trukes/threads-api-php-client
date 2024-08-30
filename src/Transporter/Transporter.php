<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\Transporter;

use GuzzleHttp\Exception\ClientException;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Trukes\ThreadsApiPhpClient\Exception\ErrorException;
use Trukes\ThreadsApiPhpClient\Exception\TransporterException;
use Trukes\ThreadsApiPhpClient\Exception\UnserializableResponse;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\AccessToken;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\BaseUri;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\BodyForm;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\Headers;
use Trukes\ThreadsApiPhpClient\Transporter\ValueObject\QueryParams;
use Trukes\ThreadsApiPhpClient\ValueObject\Payload;
use Trukes\ThreadsApiPhpClient\ValueObject\Response;

final class Transporter implements TransporterInterface
{
    public function __construct(
        private readonly ClientInterface $httpClient,
        private readonly BaseUri $baseUri,
        private readonly Headers $headers,
        private readonly QueryParams $queryParams,
        private readonly BodyForm $bodyForm,
        private readonly AccessToken $accessToken
    )
    {
    }

    /**
     * @throws ErrorException
     * @throws UnserializableResponse|TransporterException
     */
    public function request(Payload $payload): Response
    {
        $request = $payload->toRequest($this->baseUri, $this->accessToken, $this->headers, $this->queryParams, $this->bodyForm);

        try {
            $response = $this->httpClient->sendRequest($request);
        } catch (ClientExceptionInterface $clientException) {
            if ($clientException instanceof ClientException) {
                $this->throwIfJsonError($clientException->getResponse(), $clientException->getResponse()->getBody()->getContents());
            }

            throw new TransporterException($clientException);
        }

        $contents = $response->getBody()->getContents();

        $this->throwIfJsonError($response, $contents);

        try {
            $data = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $jsonException) {
            throw new UnserializableResponse($jsonException);
        }

        return Response::from($data, $response->getHeaders());
    }

    /**
     * @throws ErrorException
     * @throws UnserializableResponse
     */
    private function throwIfJsonError(ResponseInterface $response, string|ResponseInterface $contents): void
    {
        if ($response->getStatusCode() < 400) {
            return;
        }

        if (! str_contains($response->getHeaderLine('Content-Type'), 'application/json')) {
            return;
        }

        if ($contents instanceof ResponseInterface) {
            $contents = $contents->getBody()->getContents();
        }

        if(empty($contents)){
            throw new ErrorException(['message' => $response->getBody()->getContents(), 'code' => $response->getStatusCode()]);
        }

        try {
            $response = json_decode($contents, true, flags: JSON_THROW_ON_ERROR);

            if (isset($response['error'])) {
                throw new ErrorException($response['error']);
            }
        } catch (JsonException $jsonException) {
            throw new UnserializableResponse($jsonException);
        }
    }
}