<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */


namespace Magento\StaticContentDeployRedisBugReproducer\Plugin

use \Magento\Framework\App\Config\ScopeConfigInterface;

class PackagePlugin
{

    public function beforeFiles( Magento\Deploy\Package\Package $package )
    {
        echo ("test\n");
    }
}
