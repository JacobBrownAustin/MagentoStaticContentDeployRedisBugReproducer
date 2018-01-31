<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
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
        if (1) {
            echo("beforeGetFiles called from pid: " . getmypid() . "\n");
        }
		$startTime = time();
        $frontendinterface = $this->cacheFrontendPool->get("default");
        while ( time() < $startTime + 5) {
            $data = $frontendinterface->load("global::DiConfig");
			$test = true;
        }
    }
}
