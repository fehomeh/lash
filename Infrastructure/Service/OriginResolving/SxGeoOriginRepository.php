<?php

namespace Lash\Infrastructure\Service\OriginResolving;

use GuzzleHttp\Client;
use Lash\Domain\Order\OriginRepositoryInterface;

class SxGeoOriginRepository implements OriginRepositoryInterface
{
    /**
     * @var string
     */
    private const DEFAULT_COUNTRY_CODE = 'US';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $url;

    /**
     * SxGeoOriginRepository constructor.
     * @param Client $client
     * @param string $url
     */
    public function __construct(Client $client, string $url)
    {
        $this->client = $client;
        $this->url = $url;
    }

    /**
     * @inheritdoc
     */
    public function getCountryCode(string $ipAddress): string
    {
        $countryCode = self::DEFAULT_COUNTRY_CODE;
        try {
            $response = $this->client->get($this->url . $ipAddress);
            $decodedResponse = json_decode($response->getBody(), true);
            if (isset($decodedResponse['country']['iso'])) {
                $countryCode = $decodedResponse['country']['iso'];
            }
        } catch (\Throwable $exception) {
        }

        return $countryCode;
    }
}
