<?php

namespace Lash\Infrastructure\Persistence\File;

use Illuminate\Contracts\Cache\Repository;
use Lash\Domain\Order\OriginRequestCounterInterface;

class OriginRequestCounter implements OriginRequestCounterInterface
{
    /**
     * @var string
     */
    private const KEY_PREFIX = 'order_origin_counter_';

    /**
     * @var Repository
     */
    private $cache;

    /**
     * @var int
     */
    private $counterTtl;

    /**
     * OriginRequestCounter constructor.
     * @param Repository $cache
     * @param int $counterTtl
     */
    public function __construct(Repository $cache, int $counterTtl)
    {
        $this->cache = $cache;
        $this->counterTtl = $counterTtl;
    }

    /**
     * @inheritdoc
     */
    public function increment(string $country): void
    {
        $cacheKey = $this->getKey($country);
        if (!$this->cache->has($cacheKey)) {
            $interval = new \DateInterval('PT'. $this->counterTtl . 'S');
            $this->cache->add($cacheKey, 0, $interval);
        }
        $this->cache->increment($cacheKey);
    }

    /**
     * @inheritdoc
     */
    public function countRequest(string $country): int
    {
        return $this->cache->get($this->getKey($country), 0);
    }

    /**
     * @param string $country
     *
     * @return string
     */
    private function getKey(string $country): string
    {
        return self::KEY_PREFIX . $country;
    }
}
