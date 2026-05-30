<?php

namespace app\forms;

use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;

class QuickContactForm extends \yii\base\Model
{
    public ?string $phone = null;

    public ?string $email = null;

    public ?string $message = null;


    public function rules()
    {
        return [
            ['message', 'required'],
            ['message', 'string', 'length' => [2, 2000]],
            ['email', 'email'],
            ['phone', 'string', 'max' => 30],
            // require at least a phone or an email so we can reply
            ['phone', 'validateContact'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone'   => 'Phone',
            'email'   => 'Email',
            'message' => 'Message',
        ];
    }

    public function validateContact($attribute, $params): void
    {
        if (empty($this->phone) && empty($this->email)) {
            $this->addError('phone', 'Please enter a phone number or an email.');
        }
    }

    public function contact(): bool
    {
        $telegram = new Telegram('7951628769:AAEKKx5gLcP2Cn90zJES8iv2TGc0sNzunrM', 'lev_pro_construction_bot');

        $message = "\xf0\x9f\x9f\xa2 Швидкий запит з сайту \n\n";
        $message .= "\xf0\x9f\x93\x83 {$this->message} \n\n";
        if (!empty($this->phone)) {
            $message .= "\xe2\x98\x8e {$this->phone} \n";
        }
        if (!empty($this->email)) {
            $message .= "\xf0\x9f\x93\xa7 {$this->email}";
        }

        $response = Request::sendMessage([
            'chat_id'    => \Yii::$app->params['telegramChatId'],
            'text'       => $message,
            'parse_mode' => 'Markdown',
        ]);

        return $response->isOk();
    }
}
