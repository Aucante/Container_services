<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\DependencyInjection\LoggerCompilerPass;
use App\Logger;
use App\Mailer\GmailMailer;
use App\Mailer\MailerInterface;
use App\Mailer\SmtpMailer;
use App\Texter\FaxTexter;
use App\Texter\SmsTexter;
use App\Texter\TexterInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

require __DIR__ . '/vendor/autoload.php';

$container = new ContainerBuilder();

//$loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/config'));
//$loader->load('services.php');

$loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/config'));
$loader->load('services.yaml');

$container->addCompilerPass(new LoggerCompilerPass);

$container->compile();

$controller = $container->get(OrderController::class);

$httpMethod = $_SERVER['REQUEST_METHOD'];

if($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__. '/views/form.html.php';
