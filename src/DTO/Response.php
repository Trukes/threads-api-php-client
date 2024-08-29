<?php
declare(strict_types=1);

namespace Trukes\ThreadsApiPhpClient\DTO;

final class Response
{
    /**
     * Creates a new Response value object.
     *
     * @param  TData  $data
     */
    private function __construct(
        private readonly array|string $data,
        private readonly array $meta
    ) {
        // ..
    }

    /**
     * Creates a new Response value object from the given data and meta information.
     *
     * @param  TData  $data
     * @param  array<string, array<int, string>>  $headers
     * @return Response<TData>
     */
    public static function from(array|string $data, array $headers = []): self
    {
        return new self($data, $headers);
    }

    /**
     * Returns the response data.
     *
     * @return array|string
     */
    public function data(): array|string
    {
        return $this->data;
    }

    /**
     * Returns the meta information.
     */
    public function meta(): array
    {
        return $this->meta;
    }
}