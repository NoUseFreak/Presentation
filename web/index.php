<?php
/**
 * This file is part of the Presentation package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */ 

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

include __DIR__ . '/../app/config/config.php';

$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.path' => __DIR__.'/../app/views',
));

$app->get('/', function() use ($app) {
	return $app['twig']->render('client.html.twig', array());
});

$app->get('/master', function() use ($app) {
	return $app['twig']->render('master.html.twig', array());
});

$app->run();
