<?php
/**
 * Created: Ákos Kiszely
 * Date: 2015.06.01.
 * Time: 12:13
 */

namespace app\components;

use yii\base\Component;
use yii\web\IdentityInterface;

class ConsoleUser extends Component
{
    public $id = 1;
    public $name = "Console";

    public function getIdentity($autoRenew = true)
    {
        return $this->null;
    }
}