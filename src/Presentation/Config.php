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

class Config
{
	protected $hostIp;
	protected $hostPort;

	/**
	 * @param mixed $hostIp
	 */
	public function setHostIp($hostIp)
	{
		$this->hostIp = $hostIp;
	}

	/**
	 * @return mixed
	 */
	public function getHostIp()
	{
		return $this->hostIp;
	}

	/**
	 * @param mixed $hostPort
	 */
	public function setHostPort($hostPort)
	{
		$this->hostPort = $hostPort;
	}

	/**
	 * @return mixed
	 */
	public function getHostPort()
	{
		return $this->hostPort;
	}

	/**
	 * @return string
	 */
	public function getHostUri()
	{
		return $this->hostIp . ':' . $this->hostPort;
	}
}
