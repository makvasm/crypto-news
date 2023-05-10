<?php

namespace App\Services\Cryptocurrency;

use App\Services\Cryptocurrency\Contracts\CryptocurrencyService;
use App\Services\Cryptocurrency\DataMappers\Contracts\CryptocurrencyDataMapper;
use App\Services\Cryptocurrency\Structs\CryptocurrencyListingResponse;
use App\Services\Cryptocurrency\Structs\CryptocurrencyListResponse;
use App\Services\Cryptocurrency\Structs\CryptocurrencyQuotesResponse;
use App\Services\Cryptocurrency\Structs\CryptocurrencyResponse;
use Exception;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerInterface;

class CoinMarketCapCryptocurrencyService implements CryptocurrencyService
{
    protected string $host;

    protected string $apiKey;

    protected float $version = 1;

    protected LoggerInterface $logger;

    protected ClientInterface $httpclient;

    protected CryptocurrencyDataMapper $dataMapper;

    public function __construct(ClientInterface $httpclient, LoggerInterface $logger, CryptocurrencyDataMapper $dataMapper)
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
    public function getCryptocurrencyList(): CryptocurrencyListResponse
    {
        try {
            $request = new Request('GET', 'v1/cryptocurrency/map');
            $response = $this->request($request);

            return $this->dataMapper->jsonToCryptocurrencyListResponse(
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
        $path = ltrim($path, '/');

        return new Uri("{$host}/$path");
    }

    public function getCryptocurrency(): CryptocurrencyResponse
    {
        return new CryptocurrencyResponse();
    }

    public function getPlatformName(): string
    {
        return 'coin_market_cap';
    }

    public function getFiatsToExchange(): array
    {
        return ['RUB'];
    }

    public function getListing(): CryptocurrencyListingResponse
    {
        try {
            $request = new Request('GET', 'v1/cryptocurrency/listings/latest');
            $response = $this->request($request);

            return $this->dataMapper->jsonToCryptocurrencyListingResponse(
                $response->getBody()
                         ->getContents()
            );
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }

    public function getQuotes(array $symbols, ?array $convert = null): CryptocurrencyQuotesResponse
    {
        try {
            $query = http_build_query([
                'symbol'  => implode(',', $symbols),
                'convert' => $convert ? implode(',', $convert) : null,
            ]);
            $request = new Request('GET', "v2/cryptocurrency/quotes/latest?$query");
            $response = $this->request($request);

            return $this->dataMapper->jsonToCryptocurrencyQuotesResponse(
                $response->getBody()
                         ->getContents()
            );
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            throw $e;
        }
    }
}
