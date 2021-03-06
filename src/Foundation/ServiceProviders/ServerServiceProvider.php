<?php

namespace Xjchengo\Foundation\ServiceProviders;

use EasyWeChat\Encryption\Encryptor;
use Xjchengo\Server\Guard;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServerServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['encryptor'] = function ($pimple) {
            return new Encryptor(
                $pimple['config']['component_app_id'],
                $pimple['config']['token'],
                $pimple['config']['aes_key']
            );
        };

        $pimple['server'] = function ($pimple) {
            $server = new Guard($pimple['config']['token']);

            $server->debug($pimple['config']['debug']);

            $server->setEncryptor($pimple['encryptor']);

            return $server;
        };
    }
}
