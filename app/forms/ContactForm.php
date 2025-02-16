<?php

namespace app\forms;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class ContactForm extends \yii\base\Model
{
    public ?string $firstName = null;

    public ?string $lastName = null;

    public ?string $phone = null;

    public ?string $email = null;

    public ?string $message = null;


    public function rules()
    {
        return [
            [['firstName', 'lastName', 'phone', 'message'], 'required'],
            [['firstName', 'lastName', 'email'], 'string', 'length' => [2, 250]],
            ['phone', 'string', 'length' => [2, 15]],
            ['email', 'email'],
            ['message', 'string', 'length' => [2, 2000]],
        ];
    }


    public function contact(): bool
    {
        $telegram = new Telegram('7951628769:AAEKKx5gLcP2Cn90zJES8iv2TGc0sNzunrM', 'lev_pro_construction_bot');

        $message = "\xf0\x9f\x9f\xa2 Нове повідомлення від {$this->firstName} {$this->lastName} \n\n";
        $message .= "\xf0\x9f\x93\x83 {$this->message} \n\n \xe2\x98\x8e {$this->phone} \n \xf0\x9f\x93\xa7 {$this->email}";

        $response = Request::sendMessage([
            'chat_id'    => \Yii::$app->params['telegramChatId'],
            'text'       => $message,
            'parse_mode' => 'Markdown',
        ]);

        return $response->isOk();
    }
}