<?php

namespace Bitter\Smartbanner\Routing;

use Bitter\Smartbanner\API\V1\Middleware\FractalNegotiatorMiddleware;
use Bitter\Smartbanner\API\V1\Configurator;
use Concrete\Core\Routing\RouteListInterface;
use Concrete\Core\Routing\Router;

class RouteList implements RouteListInterface
{
    public function loadRoutes(Router $router)
    {
        $router
            ->buildGroup()
            ->setNamespace('Concrete\Package\Smartbanner\Controller\Dialog\Support')
            ->setPrefix('/ccm/system/dialogs/smartbanner')
            ->routes('dialogs/support.php', 'smartbanner');
    }
}