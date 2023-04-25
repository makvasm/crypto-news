<?php

namespace App\Services\Fiat;

use App\Services\Fiat\Contracts\FiatService;
use App\Services\Fiat\DataMappers\Contracts\FiatDataMapper;
use App\Services\Fiat\Structs\FiatResponse;
use Exception;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerInterface;

class CoinMarketCapFiatService implements FiatService
{
    protected string $host;

    protected string $apiKey;

    protected float $version = 1;

    protected LoggerInterface $logger;

    protected ClientInterface $httpclient;

    protected FiatDataMapper $dataMapper;

    public function __construct(ClientInterface $httpclient, LoggerInterface $logger, FiatDataMapper $dataMapper)
    {
        $this->host = rtrim(config('api.CoinMarketCap.host'), '/');
        $this->apiKey = config('api.CoinMarketCap.api_key');
        $this->logger = $logger;
        $this->httpclient = $httpclient;
        $this->dataMapper = $dataMapper;
    }

    /**
     * @throws Exception|ClientExceptionInterface
     */
    public function getFiatList(): Structs\FiatListResponse
    {
        try {
            $request = new Request('GET', 'fiat/map');
            $response = $this->request($request);

            return $this->dataMapper->jsonToFiatListResponse(
                $response->getBody()
                         ->getContents()
            );
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }

    /**
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     * @throws ClientExceptionInterface
     */
    protected function request(RequestInterface $request): ResponseInterface
    {
        $request = $request->withAddedHeader('X-CMC_PRO_API_KEY', $this->apiKey);
        $request = $request->withUri($this->getPreparedUri($request->getUri()));

        return $this->httpclient->sendRequest($request);
    }

    protected function getPreparedUri($path): UriInterface
    {
        $host = rtrim($this->host, '/');
        $pathWithoutVersion = ltrim($path, '/');

        return new Uri("{$host}/v{$this->version}/{$pathWithoutVersion}");
    }

    public function getFiat(): FiatResponse
    {
        return new FiatResponse();
    }

    public function getPlatformName(): string
    {
        return 'coin_market_cap';
    }
}
