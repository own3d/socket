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
    'secret' => env('OWN3D_SOCKET_SECRET'),
],
```

## Configure as Laravel Broadcaster

OWN3D Socket can be also used as Laravel Broadcaster. Important is, all events MUST prefixed with your own3d/id client id. This will be already done in the broadcaster and can be configured with the `room_prefix`.

Add the `own3d-socket` configuration within the `config/broadcasting.php` config file.

```php
'own3d-socket' => [
    'driver' => 'own3d-socket',
    'room_prefix' => env('OWN3D_ID_KEY'),
],
```

On the client side, use:

```javascript
import {io} from 'socket.io-client';

const socket = io('https://socket-hel1-1.own3d.dev', {
    withCredentials: true,
});

socket
    .on('connect', () => {
        console.log('Socket connected.', socket.id);
        socket.emit('room', '<room-prefix>.<channel-name>');
    })
    .on('App\\Events\\ExampleEvent', (e) => {
        // e contains additional event data
    });
```

```php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ExampleEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private string $userId;
    
    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('channel-name');
    }
}
```