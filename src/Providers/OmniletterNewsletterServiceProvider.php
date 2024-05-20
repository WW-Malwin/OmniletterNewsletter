<?php
namespace OmniletterNewsletter\Providers;

use Plenty\Plugin\ServiceProvider;

class OmniletterNewsletterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->getApplication()->register(OmniletterNewsletterRouteServiceProvider::class);
    }
}
