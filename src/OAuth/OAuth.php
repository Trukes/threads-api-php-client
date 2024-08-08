<?php

namespace Trukes\ThreadsApiPhpClient\OAuth;

use Trukes\ThreadsApiPhpClient\DTO\Config;
use Trukes\ThreadsApiPhpClient\Exception\OAuthException;
use Trukes\ThreadsApiPhpClient\OAuthInterface;

final class OAuth implements OAuthInterface
{
    private const PATH = 'oauth/authorize';

    private Config $threadsConfig;
    public function __construct(Config $threadsConfig)
    {
        $this->threadsConfig = $threadsConfig;
    }

    /**
     * https://threads.net/oauth/authorize
     * ?client_id=<THREADS_APP_ID>
     * &redirect_uri=<REDIRECT_URI>
     * &scope=<SCOPE>
     * &response_type=code
     * &state=<STATE> // Optional
     */

    /**
     * @param array $options
     * @return string
     */
    public function getAuthorizationUrl(array $options = []): string
    {
        $url = sprintf(
            '%s%s?client_id=%s&redirect_uri=%s&scope=%s&response_type=%s',
            $this->threadsConfig->getAuthorizationBaseUrl(),
            self::PATH,
            $this->threadsConfig->getAppId(),
            $this->threadsConfig->getRedirectUri(),
            $options['scope'],
            'code'
        );

        if($options['state']){
            $url .= '&state='.$options['state'];
        }

        return $url;
    }

    public function validateAuthorizationRequest(array $options = []): void
    {
        $this->validateAuthorizationRequest($options);

        return $this->validateResponseCode($options);
    }

    /**
     * @throws OAuthException
     */
    private function validateResponseError(array $response): void
    {
        if(!empty($response['error'])){
            throw OAuthException::failed($response['error'], $response['error_description'], $response['error_description']);
        }
    }

    /**
     * @throws OAuthException
     */
    private function validateResponseCode(array $response): string
    {
        if(empty($response['code'])){
            throw OAuthException::failed('access_denied', 'no_code_provided', 'The "code" parameter is missing');
        }

        return $response['code'];
    }
}