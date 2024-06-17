<?php

namespace Own3d\Socket\Support;

use Firebase\JWT\JWT;

/**
 * Helper class to generate tokens for the socket server.
 */
class SocketToken
{
    const ALGORITHM = 'HS256';

    /**
     * Generates a pre-signed token for the socket server to join a room.
     * This will generate a token that can be used to authenticate with the socket server to join a specific room.
     * If the room starts with `private`, the socket server will also join the public room with the same name.
     */
    public static function auth(string|array $room): string
    {
        return self::encode(self::payload('auth', [
            'type' => 'auth',
            'room' => $room,
        ], 60 * 15));
    }

    /**
     * Generate a pre-signed token for the socket server to emit a message.
     */
    public static function emit(string|array $room, string $event, array $data): string
    {
        return self::encode(self::payload('emit', [
            'room' => $room,
            'event' => $event,
            'data' => $data,
        ], 60 * 15));
    }

    /**
     * Helper to generate a JWT token.
     */
    public static function encode(array $payload): string
    {
        return JWT::encode($payload, config('services.own3d-socket.secret'), self::ALGORITHM);
    }

    /**
     * Helper to decode a JWT token.
     */
    private static function payload(string $type, array $extra, float $ttl): array
    {
        return array_merge([
            'type' => $type,
            'iat' => time(),
            'exp' => time() + $ttl,
        ], $extra);
    }
}