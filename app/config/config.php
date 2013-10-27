<?php
/**
 * This file is part of the Presentation package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$config = new \Presentation\Config();
$config->setHostIp($_SERVER['HTTP_HOST']);
$config->setHostPort(8123);

if (isset($app)) {
	$app->before(function (\Symfony\Component\HttpFoundation\Request $request) use ($app, $config) {
		$app['config'] = $config;

		$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
			$twig->addGlobal('config', $app['config']);

			return $twig;
		}));
	});
}

return $config;
