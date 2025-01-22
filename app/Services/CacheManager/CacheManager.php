<?php

namespace App\Services\CacheManager;

class CacheManager
{
    public static function editCache(string $cacheKey, array $newData): void
    {
        $cache = \Cache::get($cacheKey);

        $updatedCache = array_merge($cache, $newData);

        \Cache::put($cacheKey, $updatedCache);
    }
}
