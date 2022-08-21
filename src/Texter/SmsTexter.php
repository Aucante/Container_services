<?php

namespace App\Texter;

use App\HasLoggerInterface;
use App\Logger;
use App\Mailer\MailerInterface;

class SmsTexter implements TexterInterface, HasLoggerInterface
{
    protected $serviceDsn;
    protected $key;
    protected $logger;

    public function __construct(string $serviceDsn, string $key, MailerInterface $mailer)
    {
        var_dump("blablablaBLA : ", $mailer);
        $this->serviceDsn = $serviceDsn;
        $this->key = $key;
    }

    public function send(Text $text)
    {
        var_dump("ENVOI DE SMS : ", $text);
    }

    public function setlogger(Logger $logger)
    {
        $this->logger = $logger;
        $this->logger->log("ca marche SMS");
    }
}
