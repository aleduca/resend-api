<?php

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__, 2));
$dotenv->load();

$resend = Resend::client($_ENV['RESEND_API_KEY']);

try {
  $result = $resend->emails->send([
    'from' => 'Alexandre Cardoso <onboarding@resend.dev>',
    'to' => ['xandecar@hotmail.com'],
    'subject' => 'Hello world Resend',
    'html' => '<strong>It works!</strong>',
  ]);
} catch (\Exception $e) {
  exit('Error: ' . $e->getMessage());
}

dd($result->toJson());
