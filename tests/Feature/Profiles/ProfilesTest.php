<?php

namespace Tests\Feature\Profiles;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Trukes\ThreadsApiPhpClient\DTO\Payload;
use Trukes\ThreadsApiPhpClient\DTO\Response;
use Trukes\ThreadsApiPhpClient\Feature\Profiles\DTO\Profile;
use Trukes\ThreadsApiPhpClient\Feature\Profiles\Profiles;
use Trukes\ThreadsApiPhpClient\TransporterInterface;

final class ProfilesTest extends TestCase
{
    protected TransporterInterface $transporter;

    protected Profiles $profiles;

    #[DataProvider('dataProviderProfiles')]
    public function testProfiles(
        string   $threadsUserId,
        array    $fields,
        array    $queryParameters,
        Payload  $payload,
        Response $response,
        array    $expectedItem
    ): void
    {
        $this->transporter
            ->expects(self::once())
            ->method('request')
            ->with($payload)
            ->willReturn($response);

        $list = $this->profiles->getProfileInformation($threadsUserId, $fields, $queryParameters);

        self::assertEquals(
            Profile::fromArray($expectedItem),
            $list
        );
    }

    public static function dataProviderProfiles(): array
    {
        return [
            'profiles' => [
                'thread-user-id-1',
                [
                    'id',
                    'username',
                    'name',
                    'threads_profile_picture_url',
                    'threads_biography'
                ],
                ['since' => '2023-10-15', 'until' => '2024-10-15'],
                Payload::create(
                    TransporterInterface::GET,
                    'thread-user-id-1',
                    [
                        'since' => '2023-10-15',
                        'until' => '2024-10-15',
                        'fields' => 'id,username,name,threads_profile_picture_url,threads_biography'
                    ]
                ),
                Response::from(
                    json_decode(
                        '{
  "id": "1234567",
  "username": "threadsapitestuser",
  "name": "Threads API Test User",
  "threads_profile_picture_url": "https://scontent-sjc3-1.cdninstagram.com/link/to/profile/picture/on/threads/",
  "threads_biography": "This is my Threads bio."
}'
                        , true),

                ),
                [
                    'id' => '1234567',
                    'username' => 'threadsapitestuser',
                    'name' => 'Threads API Test User',
                    'threads_profile_picture_url' => 'https://scontent-sjc3-1.cdninstagram.com/link/to/profile/picture/on/threads/',
                    'threads_biography' => 'This is my Threads bio.'
                ]
            ],
            'profiles_with_some_fields' => [
                'thread-user-id-1',
                [
                    'id',
                    'name',
                ],
                ['since' => '2023-10-15', 'until' => '2024-10-15'],
                Payload::create(
                    TransporterInterface::GET,
                    'thread-user-id-1',
                    [
                        'since' => '2023-10-15',
                        'until' => '2024-10-15',
                        'fields' => 'id,name'
                    ]
                ),
                Response::from(
                    json_decode(
                        '{
  "id": "1234567",
  "name": "Threads API Test User"
}'
                        , true),

                ),
                [
                    'id' => '1234567',
                    'name' => 'Threads API Test User'
                ]
            ]
        ];
    }

    protected function setUp(): void
    {
        $this->transporter = self::createMock(TransporterInterface::class);
        $this->profiles = new Profiles($this->transporter);
    }
}