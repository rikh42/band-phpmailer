<?php
/**
 * This file is part of the Small Neat Box Framework
 * Copyright (c) 2011-2012 Small Neat Box Ltd.
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 */

namespace phpmailer\email;
use snb\email\EmailAbstract;

/**
 * Sends an email using PHPMailer
 */
class PHPMailerEmail extends EmailAbstract
{
    public function send()
    {
        // Create a PHP Mailer object and set it up
        $mailer = new \PHPMailer(true);
        $mailer->IsMail();

        // Set the emails subject
        $mailer->Subject = $this->subject;

        // Set the from address
        if (!empty($this->from)) {
            $mailer->SetFrom($this->from['email'], $this->from['name'], true);
        }

        // Set the to address
        foreach($this->to as $to) {
            $mailer->AddAddress($to['email'], $to['name']);
        }

        // cc
        foreach($this->cc as $cc) {
            $mailer->AddCC($cc['email'], $cc['name']);
        }

        // bcc
        foreach($this->bcc as $bcc) {
            $mailer->AddBCC($bcc['email'], $bcc['name']);
        }

        // If we have an HTML body, set that on the message
        // and mark it as an HTML email
        if (!empty($this->htmlBody)) {
            $mailer->Body = $this->htmlBody;
            $mailer->AltBody = $this->textBody;
            $mailer->IsHTML();
        } else {
            $mailer->Body = $this->textBody;
        }

        // Attachments
        foreach($this->attachments as $attachment) {
            $mailer->AddStringAttachment($attachment['content'], $attachment['filename'], 'base64', $attachment['mime']);
        }

        // Finally, try and send teh message
        $mailer->Send();
    }
}
