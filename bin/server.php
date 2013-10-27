<?php
/**
 * This file is part of the Presentation package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(__DIR__ . '/../vendor/autoload.php');

use Ratchet\Wamp\WampServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require_once __DIR__ . '/../src/config.php';

$server = IoServer::factory(
    new WsServer(
        new WampServer(
            new \Presentation\Presentation()
        )
    ), $hostPort
);
$server->run();
