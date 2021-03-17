# OWN3D Socket

## Installation

```bash
composer require own3d/socket
```

## Configuration

Add the `own3d-socket` configuration within the `config/services.php` config file.

```php
'own3d-socket' => [
    'username' => env('OWN3D_SOCKET_USERNAME', 'own3d-socket'),
    'password' => env('OWN3D_SOCKET_PASSWORD')
],
```