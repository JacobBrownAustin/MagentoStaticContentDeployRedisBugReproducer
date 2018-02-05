<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\StaticContentDeployRedisBugReproducer;

// use Magento\Framework\Cache\FrontendInterface as CacheFrontendInterface;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Cache\Frontend\Pool as CacheFrontendPool;

class CacheUser
{

    /**
     * @var CacheInterface
     */
    protected $cacheInterface;

    /**
     * @param CacheFrontendPool $cacheFrontendPool
     */
    public function __construct(
        CacheFrontendPool $cacheFrontendPool
    ) {
        $this->cacheInterface = $cacheFrontendPool->get("default");
    }

    public function doCacheStuff()
    {
        if (0) {
            echo("doCacheStuff called from pid: " . getmypid() . "\n");
        }
        $startTime = time();
        $frontendinterface = $this->cacheInterface;
        $randomstring1 = bin2hex(openssl_random_pseudo_bytes(20));
        $randomstring2 = bin2hex(openssl_random_pseudo_bytes(20));
        $randomstring3 = bin2hex(openssl_random_pseudo_bytes(20));
        $data = $frontendinterface->save($randomstring1, $randomstring2);
        $data = $frontendinterface->load($randomstring1);
        $data = $frontendinterface->load($randomstring3);
        $test = true;
    }
}
