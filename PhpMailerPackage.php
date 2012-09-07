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
use snb\core\AutoLoadContainer;

class PhpMailerPackage extends ContainerAware implements PackageInterface
{
    public function boot(KernelInterface $kernel)
    {
        // PHP Mailer expects it files to just be included, and has not
        // been designed around PSR-0 Autoloaders. We can arrange for it
        // to be loaded by adding a direct mapping though.
        AutoLoadContainer::addMappings(array(
            'PHPMailer' => __DIR__.'/PHPMailer/class.phpmailer.php'));

        // Make the 2 email classes we provide available as general services
        // If you want to use them though, you should really just set the
        // 'email' service to the one that you would prefer to use for everything

        // First the normal email service using PHPMailer
        $kernel->addService('email.phpmailer', '\phpmailer\email\PHPMailerEmail')
            ->setMultiInstance();

        // and then a special Debug emailer that lets you override to and from
        // using the config settings
        $kernel->addService('email.devmailer', '\phpmailer\email\DevEmail')
            ->setMultiInstance()
            ->setArguments(array('::service::config'));
    }
}
