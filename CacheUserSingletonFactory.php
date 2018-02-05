<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\StaticContentDeployRedisBugReproducer;

use Magento\Framework\App\Cache\Frontend\Pool as CacheFrontendPool;

class CacheUserSingletonFactory
{

    /**
     * @var CacheFrontendPool
     */
    protected $cacheFrontendPool;

    /**
     * @param CacheFrontendPool $cacheFrontendPool
     */
    public function __construct(
        CacheFrontendPool $cacheFrontendPool
    ) {
        $this->cacheFrontendPool = $cacheFrontendPool;
    }

    /**
     * @var CacheUser
     */
    private static $cacheUser = null;

    public function create() : CacheUser
    {
        if (0) {
            echo("CacheUserSingletonFactory::create called from pid: " . getmypid() . "\n");
        }
        if (null === $this->cacheUser) {
            $this->cacheUser = new CacheUser($this->cacheFrontendPool);
        }
        return $this->cacheUser;
    }
}
