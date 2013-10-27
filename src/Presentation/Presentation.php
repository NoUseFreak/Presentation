<?php
/**
 * This file is part of the Presentation package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Presentation;

use Ratchet\ConnectionInterface as Conn;

class Presentation implements \Ratchet\Wamp\WampServerInterface
{
    protected $slidePosition = 0;

    public function onPublish(Conn $conn, $topic, $event, array $exclude, array $eligible)
    {
        $topic->broadcast('event' . $event);
    }

    public function onCall(Conn $conn, $id, $topic, array $params)
    {
        switch ($topic->getId()) {
            case 'presentationControl':
				$topic->broadcast($this->presentationControl($params));
                break;
            case 'getPosition':
				return $conn->callResult($id, $this->getPosition($params));
        }
    }

	protected function getPosition($params)
	{
		return array(
			'position' => $this->slidePosition,
		);
	}

	protected function presentationControl($params)
	{
		switch ($params['action']) {
			case 'prev':
				$this->slidePosition--;
				break;
			default:
				$this->slidePosition++;
		}

		return array(
			'position' => $this->slidePosition,
		);
	}

	// No need to anything, since WampServer adds and removes subscribers to Topics automatically
    public function onSubscribe(Conn $conn, $topic)
    {
    }

    public function onUnSubscribe(Conn $conn, $topic)
    {
    }

    public function onOpen(Conn $conn)
    {
    }

    public function onClose(Conn $conn)
    {
    }

    public function onError(Conn $conn, \Exception $e)
    {
    }
}
