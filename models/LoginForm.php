<?php
/**
 * Created: Ákos Kiszely
 * Date: 2014.11.06.
 * Time: 10:25
 */

namespace app\models;

use app\components\DinaAuthentication;
use dektrium\user\helpers\Password;
use dektrium\user\models\LoginForm as BaseLoginForm;

class LoginForm extends BaseLoginForm
{

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['login', 'trim'],
            ['rememberMe', 'boolean'],
        ];
    }


    public function login()
    {
        if ($this->validate()) {
            return \Yii::$app->getUser()->login($this->user, $this->rememberMe ? $this->module->rememberFor : 0);
        } else {
            return false;
        }

    }


    /** @inheritdoc */
    public function beforeValidate()
    {
        $dinaAuth = new DinaAuthentication();

        $isAuthenticated = $dinaAuth->authenticate($this->login, $this->password);
        if (!$isAuthenticated) {
            $this->addError('password', \Yii::t('user', 'Invalid login or password'));
            return false;
        };

        return true;
    }



}