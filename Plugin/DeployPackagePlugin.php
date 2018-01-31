<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */


namespace Magento\StaticContentDeployRedisBugReproducer\Plugin;

use Magento\Deploy\Package\Package;
use Magento\Deploy\Service\DeployPackage;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Cache\Frontend\Pool as CacheFrontendPool;

class DeployPackagePlugin
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

    public function beforeDeploy( DeployPackage $deployPackage, Package $package, array $options, $skipLogging = false )
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
