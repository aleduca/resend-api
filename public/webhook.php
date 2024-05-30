<?php

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();

$payload = file_get_contents('php://input');
$headers = getallheaders();

try {
  $wh = new \Svix\Webhook($_ENV['WEBHOOK_KEY']);
  $json = $wh->verify($payload, [
    'svix-id' => $headers['Svix-Id'],
    'svix-timestamp' => $headers['Svix-Timestamp'],
    'svix-signature' => $headers['Svix-Signature'],
  ]);
  file_put_contents('webhook.log', $payload . PHP_EOL, FILE_APPEND);
  file_put_contents('headers.log', json_encode($headers) . PHP_EOL, FILE_APPEND);
} catch (\Throwable $th) {
  file_put_contents('errors.log', $th->getMessage() . PHP_EOL, FILE_APPEND);
}
