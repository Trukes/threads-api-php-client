# Features

## Posts
https://developers.facebook.com/docs/threads/posts

### Thread Posts
```php
interface PostsInterface
{
    public function createMediaContainer(string $threadsUserId, array $data): Response;
    public function publishMediaContainer(string $threadsUserId, array $data): Response;
}
```

