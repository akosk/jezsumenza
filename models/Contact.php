<?php
/**
 * Created by PhpStorm.
 * User: akosk
 * Date: 12/14/2016
 * Time: 1:51 PM
 */

namespace app\models;
use Yii;


class Contact extends ContactBase
{

    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setCc(['sysadmin@jezsu.hu'])
                ->setFrom([$this->user->email => $this->user->profile->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body."\n\n Feladó: {$this->user->email} (IP: {$this->ip})")
                ->send();

            return true;
        } else {
            return false;
        }
    }

}