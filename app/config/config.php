<?php
/**
 * This file is part of the Presentation package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$app->before(function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
	$config = array(
		'hostIp' => $_SERVER['HTTP_HOST'],
		'hostPort' => 8123,
	);

	$config['hostUri'] = $config['hostIp'] . ':' . $config['hostPort'];

	$app['config'] = $config;

	$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
		$twig->addGlobal('config', $app['config']);

		return $twig;
	}));
});
