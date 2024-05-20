<?php
namespace OmniletterNewsletter\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Templates\Twig;

class ConfigController extends Controller
{
    public function show(Twig $twig, ConfigRepository $config)
    {
        $apiKey = $config->get('OmniletterNewsletter.api_key');
        $apiUrl = $config->get('OmniletterNewsletter.api_url');

        return $twig->render('OmniletterNewsletter::config', ['apiKey' => $apiKey, 'apiUrl' => $apiUrl]);
    }

    public function save(Request $request, ConfigRepository $config)
    {
        $config->set('OmniletterNewsletter.api_key', $request->input('apiKey'));
        $config->set('OmniletterNewsletter.api_url', $request->input('apiUrl'));

        return $this->show($request, $config);
    }
}
