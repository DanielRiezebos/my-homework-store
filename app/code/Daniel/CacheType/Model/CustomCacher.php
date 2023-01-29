<?php

declare(strict_types=1);

namespace Daniel\CacheType\Model;

use Magento\Framework\App\CacheInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Daniel\CacheType\Model\Cache\Type\CacheType;

class CustomCacher
{
    private CacheInterface $cache;
    private SerializerInterface $serializer;

    public function __construct(CacheInterface $cache, SerializerInterface $serializer)
    {
        $this->cache = $cache;
        $this->serializer = $serializer;
    }

    public function write($input) : void
    {
        // Store the input in the custom cache to study Magento 2 cache functionality
        $this->cache->save(
            $this->serializer->serialize($input),
            CacheType::TYPE_IDENTIFIER,
            [CacheType::CACHE_TAG]
        );
    }
    /**
     * @return string|int|float|bool|array|null
     */
    public function read()
    {
        $cachedData = $this->cache->load(CacheType::TYPE_IDENTIFIER);
        if (!$cachedData) {
            return null;
        }

        return $this->serializer->unserialize($this->cache->load(CacheType::TYPE_IDENTIFIER));
    }
}
