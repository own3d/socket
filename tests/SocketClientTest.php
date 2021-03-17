<?php

namespace Own3d\Socket\Tests;

use Own3d\Socket\SocketClient;

class SocketClientTest extends TestCase
{
    public function testSubscribe(): void
    {
        $socketClient = new SocketClient();

        $socketClient->emit([
            'room' => 'twitch.106415581',
            'event' => 'notifysub',
            'data' => [
                'subscription' => [
                    'type' => 'follow',
                    'version' => '1',
                    'condition' => [
                        'platform' => 'twitch',
                        'platform_id' => '106415581',
                    ]
                ],
                'event' => [
                    'name' => 'OWN3D',
                ],
            ],
        ]);
    }
}
