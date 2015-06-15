<?php
/**
 * Created: Ákos Kiszely
 * Date: 2014.11.06.
 * Time: 10:25
 */

namespace app\models;

use app\components\DinaAuthentication;
use dektrium\user\Finder;
use dektrium\user\models\LoginForm as BaseLoginForm;
use Yii;

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

        $this->createUserIfNotExists($dinaAuth);

        return true;
    }

    public function createUserIfNotExists(DinaAuthentication $dinaAuth)
    {
        $finder = Yii::createObject(Finder::className());

        $this->user = $finder->findUserByUsernameOrEmail($this->login);

        if (!$this->user) {
            $entry = $dinaAuth->getEntryByUID($this->login);

            $user = new User();
            $user->scenario = 'create';
            $user->username = $this->login;
            $user->password = $this->password;
            $user->email = $entry['Email'];


            if ($user->create()) {
                $this->user = $user;
                $profile = $user->profile;
                $profile->name=$entry['Nev'];
                $profile->public_email=$user->email;
                if (!$profile->save(false)) {

                    $this->addError('login', \Yii::t('user', 'A felhasználó profil létrehozása sikertelen'));
                }
            } else {
                $this->addError('login', \Yii::t('user', 'A felhasználó létrehozása sikertelen'));
            }
        }

    }


}