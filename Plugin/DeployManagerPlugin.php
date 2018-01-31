<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/* This class is a plugin for Magento\Deploy\Service\DeployPackage.  It intercepts the 'deploy' method.
 * We are using it to help reproduce this issue because deploy is one of the first things called from within the child process.
 * The main thing this plugin does is have redis get called over and over for 5 seconds. 
 * That way, we should have multiple children calling Credis and using the redis connection at the same time.
 * Since we already set up the redis connection in the parent process, the children should be using the parent's connection to the server which is the cause of the issue.
 */

namespace Magento\StaticContentDeployRedisBugReproducer\Plugin;

use Magento\Deploy\Model\DeployManager;
use Magento\Framework\App\CacheInterface;
use Magento\Framework\App\Cache\Frontend\Pool as CacheFrontendPool;

class DeployManagerPlugin
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

    public function beforeDeploy( DeployManager $deployPackage )
    {
        if (1) {
            echo("beforeDeploy called from pid: " . getmypid() . "\n");
        }
        /* Originally, I had meant to be creating the random strings in the while loop, but it fails just as fine if we keep calling the same string, so this is actually better this way. We really don't even need random strings. */
        $randomstring1 = bin2hex(openssl_random_pseudo_bytes(20));
        $randomstring2 = bin2hex(openssl_random_pseudo_bytes(20));
        $randomstring3 = bin2hex(openssl_random_pseudo_bytes(20));
        $startTime = time();
        $frontendinterface = $this->cacheFrontendPool->get("default");
        while ( time() < $startTime + 0) {
            $data = $frontendinterface->save($randomstring1, $randomstring2);
            $data = $frontendinterface->load($randomstring1);
            $data = $frontendinterface->load($randomstring3);
            $test = true;
        }
    }
}
