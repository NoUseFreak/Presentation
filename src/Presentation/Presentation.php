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
	protected $slideCount;

    public function onPublish(Conn $conn, $topic, $event, array $exclude, array $eligible)
    {
        $topic->broadcast('event' . $event);
    }

    public function onCall(Conn $conn, $id, $topic, array $params)
    {
        switch ($topic->getId()) {
            case 'presentationControl':
				$this->presentationControl($conn, $id, $topic, $params);
				$this->returnPosition($conn, $id, $topic, $params);
                break;
            case 'getPosition':
				$this->returnPosition($conn, $id, $topic, $params);
				break;
        }
    }

	/**
	 * Retrieve the position of the current slide.
	 *
	 * @param Conn $conn
	 * @param $id
	 * @param $topic
	 * @param array $params
	 */
	protected function returnPosition(Conn $conn, $id, $topic, array $params)
	{
		if (is_null($this->slideCount)) {
			$this->slideCount = $params['total'];
		}

		$conn->callResult($id, array(
			'position' => $this->slidePosition,
		));
	}

	protected function presentationControl(Conn $conn, $id, $topic, array $params)
	{
		switch ($params['action']) {
			case 'prev':
				$this->slidePosition--;
				break;
			default:
				$this->slidePosition++;
		}

		if ($this->slidePosition < 0) {
			$this->slidePosition = $this->slideCount - 1;
		}
		elseif ($this->slidePosition >= $this->slideCount) {
			$this->slidePosition = 0;
		}

		$topic->broadcast(array(
			'position' => $this->slidePosition,
		));
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
