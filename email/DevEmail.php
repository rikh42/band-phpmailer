<?php
/**
 * This file is part of the Small Neat Box Framework
 * Copyright (c) 2011-2012 Small Neat Box Ltd.
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 */

namespace phpmailer\email;
use snb\email\EmailAbstract;
use snb\config\ConfigInterface;

/**
 * An Email class that can be used in development builds
 * It actually sends emails, but lets you override the to address
 * and ignores any cc and bcc addresses, so your development
 * build can capture all the emails to see what they look like
 * without accidentally sending customers emails.
 */
class DevEmail extends PHPMailerEmail
{
    protected $devEnable;       // Allow emails to be sent at all?
    protected $overrideTo;      // Who to send all emails to
    protected $overrideFrom;    // Change all emails to be from this address...


    /**
     * Pulls various config settings out of the config to
     * force emails to go to a particular destination.
     * @param \snb\config\ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        // normal construction
        parent::__construct();

        // Find the From address to use for all emails
        $this->overrideFrom = $this->wrapEmailAddress(
            $config->get('email.dev.from.email', ''),
            $config->get('email.dev.from.name'));

        // Find the To address to use for all emails
        $this->overrideTo = $this->wrapEmailAddress(
            $config->get('email.dev.to.email', ''),
            $config->get('email.dev.to.name'));

        // Find the on off switch for dev emails
        $this->devEnable = $config->get('email.dev.enable', false);

        // If there was not To address, switch off
        if ($this->overrideTo['email'] == '') {
            $this->devEnable = false;
        }
    }


    /**
     * @return bool|void
     */
    public function send()
    {
        // If we have sending email switched off
        // then pretend that everything worked just fine
        if (!$this->devEnable) {
            return true;
        }

        // cancel any addresses that had been set up
        $this->to = array();
        $this->from = array();
        $this->replyTo = array();
        $this->cc = array();
        $this->bcc = array();

        // Force the to address and from address to be what we want
        $this->to($this->overrideTo['email'], $this->overrideTo['name']);
        $this->from($this->overrideFrom['email'], $this->overrideFrom['name']);

        // send the email
        return parent::send();
    }
}
