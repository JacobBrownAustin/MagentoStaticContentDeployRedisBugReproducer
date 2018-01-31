<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */


namespace Magento\StaticContentDeployRedisBugReproducer\Plugin;

use Magento\Framework\App\Cache\Manager as CacheManager;
use Magento\Deploy\Package\Package;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Cache;
use Magento\Framework\Config\CacheInterface as ConfigCacheInterface;
use Magento\Framework\App\Cache\Frontend\Factory as CacheFrontendFactory;
use Magento\Framework\App\Cache\Frontend\Pool as CacheFrontendPool;

class PackagePlugin
{

  /**
    * @var CacheManager
    */
   protected $cacheManager;

  /**
    * @var CacheInterface
    */
   protected $cacheInterface;

  /**
    * @var ConfigCacheInterface
    */
   protected $configCacheInterface;

  /**
    * @var CacheFrontendFactory
    */
   protected $cacheFrontendFactory;

  /**
    * @var CacheFrontendPool
    */
   protected $cacheFrontendPool;

   /**
    * @param CacheManager $cacheManager
    * @param CacheInterface $cacheInterface
    * @param ConfigCacheInterface $configCacheInterface
    * @param CacheFrontendFactory $cacheFrontendFactory
    * @param CacheFrontendPool $cacheFrontendPool
    */
   public function __construct(
       CacheManager $cacheManager,
       CacheInterface $cacheInterface,
       ConfigCacheInterface $configCacheInterface,
       CacheFrontendFactory $cacheFrontendFactory,
       CacheFrontendPool $cacheFrontendPool
   ) {
       $this->cacheManager = $cacheManager;
       $this->cacheInterface = $cacheInterface;
       $this->configCacheInterface = $configCacheInterface;
       #$this->frontendCache = \Zend_Cache::factory( "Cm_Cache_Backend_Redis",
       $this->cacheFrontendFactory = $cacheFrontendFactory;
       $this->cacheFrontendPool = $cacheFrontendPool;
   }

    public function beforeGetFiles( Package $package )
    {
        if (1) {
            echo("beforeGetFiles called from pid: " . getmypid() . "\n");
        }
		$startTime = time();
        # nope # $frontendinterface = $this->cacheFrontendFactory->create();
        $frontendinterface = $this->cacheFrontendPool->get("default");
        while ( time() < $startTime + 5) {
		    # nope # $this->cacheInterface->load("blah-blah-blah");
            # nope # $blah = $this->configCacheInterface->load("global::DiConfig");
            $data = $frontendinterface->load("global::DiConfig");
			$test = true;
        }
    }
}
