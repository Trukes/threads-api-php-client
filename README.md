# Threads Meta API PHP Integration [WIP]

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://opensource.org/licenses/MIT)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D%208.1-8892BF.svg)](https://php.net/)

A PHP library for seamless integration with the Threads API by Meta. This package provides a simple and intuitive interface for interacting with the API, making it easy to integrate with PHP applications.

## Features

- **Publishing**: Upload and publish Threads media objects and check their status.
- **Media Retrieval**: Retrieve Threads media objects.
- **Reply Management**: Retrieve replies and conversations and hide/unhide replies.
- **User**: Retrieve a Threads user's posts, publishing limit, and profile.
- **Insights**: Retrieve insights for Threads media objects and users.

### Coming soon
- **Authentication**: [Issue](https://github.com/Trukes/threads-api-php-client/issues/9) - Support for OAuth2 authentication.

## Requirements

- PHP 8.1 or higher

## Installation

Installation is done via [Composer](https://getcomposer.org/). Simply run the following command:

```bash
composer require trukes/threads-api-php-client
```

## Basic Usage

### Client

Before using the API, you need to create a client:

```php
require 'vendor/autoload.php';

use Trukes\ThreadsApiPhpClient\Threads;

$client = Threads::client('<your_token_here>');

```

### Create a Post

```php
$create = $client->publish()->create(
    'threads_user_id',
    'media_type',
    'text',
    'image_url',
    'video_url',
    'is_carousel_item',
    'children',
    'reply_to_id',
    'reply_control',
    'allowlisted_country_codes',
    'all_text',
)->data();

echo 'Post created successfully. Media container ID: ' . $response['id'];
```


### Publish a Post

```php
$create = $client->publish()->publish(
    'threads_user_id',
    '129984213'
)->data();

echo 'Post created successfully. Media container ID: ' . $response['id'];
```

## Threads Documentation

Complete META Threads documentation can be found [here](https://developers.facebook.com/docs/threads/reference).


## Package Documentation

Complete documentation can be found [here](https://github.com/Trukes/threads-api-php-client/wiki).

## Contributing

Contributions are welcome! If you have suggestions, fixes, or improvements, feel free to open an issue or a pull request.

### How to Contribute

1. Fork the repository.
2. Create a new branch for your feature (`git checkout -b feature/new-feature`).
3. Commit your changes (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature/new-feature`).
5. Open a Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contact

If you have any questions or suggestions, feel free to contact us at [pedro.m.a.carmo@gmail.com](mailto:pedro.m.a.carmo@gmail.com).

---

Made with ❤️ by Trukes (https://github.com/Trukes).
