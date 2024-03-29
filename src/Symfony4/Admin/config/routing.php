<?php

use ZnBundle\Storage\Symfony4\Admin\Controllers\FileController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use ZnLib\Web\Symfony4\MicroApp\Helpers\RouteHelper;

return function (RoutingConfigurator $routes) {
    RouteHelper::generateCrud($routes, FileController::class, '/storage/file');
};
