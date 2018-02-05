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
use Magento\StaticContentDeployRedisBugReproducer\CacheUser;
use Magento\StaticContentDeployRedisBugReproducer\CacheUserSingletonFactory;

class PackagePlugin
{

  /**
    * @var CacheUser
    */
   protected $cacheUser;

   /**
    * @param CacheUserSingletonFactory $cacheUserSingletonFactory
    */
   public function __construct(
       CacheUserSingletonFactory $cacheUserSingletonFactory
   ) {
       $this->cacheUser = $cacheUserSingletonFactory->create();
   }

    public function beforeGetFiles( Package $package )
    {
        if (0) {
            echo("PackagePlugin::beforeGetFiles called from pid: " . getmypid() . "\n");
        }
        $this->cacheUser->doCacheStuff();
    }
}
