<?php
require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Translation\Loader\YamlFileLoader;

$app = new Silex\Application();
$app['debug'] = true;
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider(), array(
    'locale_fallback' => 'en',
));

$app['translator'] = $app->share($app->extend('translator', function($translator, $app) {
    $translator->addLoader('yaml', new YamlFileLoader());

    $translator->addResource('yaml', __DIR__.'/translations/en.yml', 'en');
    $translator->addResource('yaml', __DIR__.'/translations/cy.yml', 'cy');

    return $translator;
}));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
  'twig.path' => __DIR__.'/views',
));

$app->get('/', function() use($app) {
    return $app['twig']->render('index.html.twig', array ());
});

$app->get('/{_locale}/', function() use($app) {
  return $app['twig']->render('index.html.twig', array ());
});

$app->get('/{_locale}/services/', function() use($app) {
    return $app['twig']->render('services.html.twig', array ());
});

$app->get('/{_locale}/gallery/', function() use($app) {
    return $app['twig']->render('gallery.html.twig', array ());
});

$app->get('/{_locale}/contact/', function() use($app) {
    return $app['twig']->render('contact.html.twig', array ());
});

$app->run();
?>
