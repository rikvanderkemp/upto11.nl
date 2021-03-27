<?php

use App\Controller\BlogController;
use App\Controller\PageController;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routes, KernelInterface $kernel) {
    $dir = $kernel->getProjectDir() . '/content-parsed/';
    $cache = json_decode(file_get_contents($dir . 'cache.json'), true, 512, JSON_THROW_ON_ERROR);

    foreach ($cache as $slug => $info) {
        $routes->add($slug, $slug)
            ->controller(PageController::class)
            ->defaults(['slug' => $slug, 'file' => $info['file'], 'properties' => $info['properties']]);
    }
};
