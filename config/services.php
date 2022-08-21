<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;


use App\Controller\OrderController;
use App\Database\Database;
use App\Logger;
use App\Mailer\GmailMailer;
use App\Mailer\MailerInterface;
use App\Mailer\SmtpMailer;
use App\Texter\FaxTexter;
use App\Texter\SmsTexter;
use App\Texter\TexterInterface;

return static function (ContainerConfigurator $configurator) {
        $parameters = $configurator->parameters();

        $parameters->set('mailer.gmail_user', 'magali@gmail.com')
            ->set('mailer.gmail_password', 'password');

        $services = $configurator->services();

        $services->defaults()->autowire(true)->public();

        $services->set('order_controller', OrderController::class)
            ->autowire(true)
            ->public()
            ->call('sayHello', [
                'bonyour',
                'jean'
            ])
            ->call('setSecondaryMailer', [
                service('mailer.gmail')
            ])

            ->set('database', Database::class)
            ->autowire(true)
            ->public()

            ->set('logger', Logger::class)
            ->autowire(true)
            ->public()

            ->set('texter.fax', FaxTexter::class)
            ->autowire(true)
            ->public()

            ->set('mailer.smtp', SmtpMailer::class)
            ->autowire(true)
            ->public()
            ->args(['smtp://localhost', 'root', '123'])

            ->set('texter.sms', SmsTexter::class)
            ->autowire(true)
            ->public()
            ->args([
                "service.sms.com",
                "apikey123"
            ])
            ->tag('with_logger')

            ->set('mailer.gmail', GmailMailer::class)
            ->autowire(true)
            ->public()
            ->args([
                '%mailer.gmail_user%',
                '%mailer.gmail_password%',
            ])
            ->tag('with_logger')

            ->alias(OrderController::class, 'order_controller')->public(true)
            ->alias(Database::class, 'database')
            ->alias(GmailMailer::class, 'mailer.gmail')
            ->alias(SmsTexter::class, 'texter.sms')
            ->alias(SmtpMailer::class, 'mailer.smtp')
            ->alias(MailerInterface::class, 'mailer.smtp')
            ->alias(FaxTexter::class, 'texter.fax')
            ->alias(TexterInterface::class, 'texter.sms')
            ->alias(Logger::class, 'logger');
};