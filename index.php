<?php

require_once 'vendor/autoload.php';

use classes\TelegramBot;
use config\Settings;
use \Dejurin\GoogleTranslateForFree;

$settings = new Settings();
$telegram = new TelegramBot($settings->getToken());

$update = $telegram->getWebhookUpdates();

$chat_id = $update['message']['chat']['id'] ?? '';
$text = $update['message']['text'] ?? '';

if ($text == '/start') {
    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => 'Привет, готов переводить!',
    ]);

}  elseif (!empty($text)) {

    if (preg_match('#[a-z]+#i', $text)) {
        $source = 'en';
        $target = 'ru';

    } else {
        $source = 'ru';
        $target = 'en';
    }

    $attempts = 5;

    $tr = new GoogleTranslateForFree();
    $result = $tr->translate($source, $target, $text, $attempts);

    if ($result) {
        $response = $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => $result,
        ]);

    } else {
        $response = $telegram->sendMessage([
            'chat_id' => $chat_id,
            'text' => 'Упс.. Я не смог это перевести..',
        ]);
    }

} else {
    $response = $telegram->sendMessage([
        'chat_id' => $chat_id,
        'text' => 'Я текстовый бот-переводчик, пожалуйста напиши мне текст..',
    ]);
}