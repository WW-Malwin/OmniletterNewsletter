<?php
namespace OmniletterNewsletter\Controllers;

use Plenty\Plugin\Controller;
use Plenty\Plugin\Http\Request;
use Plenty\Plugin\ConfigRepository;
use Plenty\Plugin\Log\Loggable;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TransferController extends Controller
{
    use Loggable;

    private $httpClient;

    public function __construct(Client $client)
    {
        $this->httpClient = $client;
    }

    public function transferSubscribers(Request $request, ConfigRepository $config)
    {
        $apiKey = $config->get('OmniletterNewsletter.api_key');
        $apiUrl = $config->get('OmniletterNewsletter.api_url');

        // Simulieren des Abrufs von Abonnentendaten
        $subscribers = $this->getSubscribers();

        $errors = [];
        foreach ($subscribers as $subscriber) {
            try {
                $response = $this->httpClient->request('POST', $apiUrl . '/recipients', [
                    'auth' => [$apiKey, ''], // API Key als Benutzername, kein Passwort
                    'json' => $subscriber,
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json'
                    ]
                ]);

                if ($response->getStatusCode() != 201) {
                    $errors[] = [
                        'subscriber' => $subscriber,
                        'status' => $response->getStatusCode(),
                        'reason' => $response->getReasonPhrase()
                    ];
                }
            } catch (RequestException $e) {
                $this->getLogger()->error('TransferController: Error transferring subscriber', [
                    'error' => $e->getMessage(),
                    'subscriber' => $subscriber
                ]);
                $errors[] = [
                    'subscriber' => $subscriber,
                    'error' => $e->getMessage()
                ];
            }
        }

        if (!empty($errors)) {
            $this->getLogger()->error('TransferController: Errors occurred during the transfer', ['errors' => $errors]);
        }

        return "Transfer completed with " . (count($subscribers) - count($errors)) . " successes and " . count($errors) . " failures.";
    }

    private function getSubscribers()
    {
        // Beispiel: Fiktive Abonnenten-Daten
        return [
            ['email' => 'example1@example.com', 'firstName' => 'John', 'lastName' => 'Doe'],
            ['email' => 'example2@example.com', 'firstName' => 'Jane', 'lastName' => 'Doe']
        ];
    }
}
