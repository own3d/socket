<?php

namespace Own3d\Socket;

use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Support\ServiceProvider as Base;

class ServiceProvider extends Base
{
    /**
     * Bootstrap socket services.
     *
     * @param BroadcastManager $broadcastManager
     * @return void
     */
    public function boot(BroadcastManager $broadcastManager)
    {
        $broadcastManager->extend('own3d-socket', function ($app, $config) {
            return new SocketBroadcaster(new SocketClient(), $config);
        });
    }
}