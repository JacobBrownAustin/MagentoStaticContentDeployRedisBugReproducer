<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/*
 * This class is a plugin for Magento\Deploy\Package\Package .  It intercepts the 'getFiles()' method.
 * We are using it because we know this method is called before the parent is forked.
 * That way, we know that Credis is being used before the fork.
 * Currently in my testing, other things were already calling credis before the fork, because the cache is accessed before the DummyCache is setup to be the Cache service.
 */

namespace Magento\StaticContentDeployRedisBugReproducer\Plugin;

use Magento\Deploy\Package\Package;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Cache\Frontend\Pool as CacheFrontendPool;

class PackagePlugin
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

    public function beforeGetFiles( Package $package )
    {
        if (0) {
            echo("beforeGetFiles called from pid: " . getmypid() . "\n");
        }
        $frontendinterface = $this->cacheFrontendPool->get("default");
        $data = $frontendinterface->load("global::DiConfig");
    }
}
