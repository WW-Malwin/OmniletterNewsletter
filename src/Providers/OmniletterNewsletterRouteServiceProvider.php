<?php
namespace OmniletterNewsletter\Providers;

use Plenty\Plugin\RouteServiceProvider;
use Plenty\Plugin\Routing\Router;

class OmniletterNewsletterRouteServiceProvider extends RouteServiceProvider
{
    public function map(Router $router)
    {
        $router->get('config', 'OmniletterNewsletter\Controllers\ConfigController@show');
        $router->post('config', 'OmniletterNewsletter\Controllers\ConfigController@save');
        $router->post('transfer', 'OmniletterNewsletter\Controllers\TransferController@transferSubscribers');
    }
}
