<?php

namespace Own3d\Socket;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Throwable;

class SocketClient
{
    public static string $baseUrl = 'https://socket-hel1-1.own3d.dev';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::$baseUrl,
        ]);
    }

    /**
     * @param string $baseUrl
     *
     * @internal only for internal and debug purposes
     */
    public static function setBaseUrl(string $baseUrl): void
    {
        self::$baseUrl = $baseUrl;
    }

    /**
     * Sends a message into the own3d websocket system.
     *
     * Required parameters:
     *  - room: string
     *  - event: string
     *  - data: array
     *
     * @param array $parameters
     * @param array|null $serverId The server id is the hostname, that should receive the message (optional).
     * @return bool
     */
    public function emit(array $parameters, array $serverId = null): bool
    {
        $options = [
            RequestOptions::JSON => $parameters,
            RequestOptions::AUTH => [
                config('services.own3d-socket.username'),
                config('services.own3d-socket.password'),
            ],
        ];

        if ($serverId) {
            $options[RequestOptions::HEADERS]['cookie'] = sprintf('serverid=%s', $serverId);
        }

        try {
            $response = $this->getClient()->post('emit', $options);
        } catch (Throwable $exception) {
            return false;
        }

        return in_array($response->getStatusCode(), [200, 204]);
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
