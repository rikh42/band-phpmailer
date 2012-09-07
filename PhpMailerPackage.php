<?php
/**
 * This file is part of the Small Neat Box Framework
 * Copyright (c) 2011-2012 Small Neat Box Ltd.
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace phpmailer;

use snb\core\ContainerAware;
use snb\core\PackageInterface;
use snb\core\KernelInterface;
use snb\core\AutoLoaderContainer;

class PhpMailerPackage extends ContainerAware implements PackageInterface
{
    public function boot(KernelInterface $kernel)
    {
    }
}
