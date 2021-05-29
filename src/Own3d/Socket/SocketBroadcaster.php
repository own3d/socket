<?php

namespace Own3d\Socket;

use Illuminate\Broadcasting\Broadcasters\Broadcaster;
use Illuminate\Broadcasting\Channel;

class SocketBroadcaster extends Broadcaster
{
    private SocketClient $client;
    private array $config;

    public function __construct(SocketClient $client, array $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    public function auth($request)
    {
        //
    }

    public function validAuthenticationResponse($request, $result)
    {
        //
    }

    public function broadcast(array $channels, $event, array $payload = []): void
    {
        /** @var Channel $channel */
        foreach ($channels as $channel) {
            $this->client->emit([
                'room' => sprintf('%s.%s', $this->config['room_prefix'], $channel->name),
                'event' => $event,
                'data' => $payload,
            ]);
        }
    }
}
