<?php

namespace App\Repository;

use Psr\Cache\CacheItemInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MixRepository
{
  public function __construct(
    private HttpClientInterface $githubContentClient,
    private HttpClientInterface $httpClient,
    private CacheInterface $cache,
    #[Autowire('%kernel.debug%')]
    private bool $isDebug
  ) {
    $this->httpClient = $httpClient;
    $this->cache = $cache;
  }

  public function findAll(): array
  {
    return $this->cache->get('mixes_data', function (CacheItemInterface $cacheItem) {
      $cacheItem->expiresAfter($this->isDebug ? 5 : 60);
      $response = $this->githubContentClient->request('GET', '/SymfonyCasts/vinyl-mixes/main/mixes.json');
      return $response->toArray();
    });
  }
}
