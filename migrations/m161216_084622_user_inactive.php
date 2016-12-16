<?php

use yii\db\Schema;
use yii\db\Migration;

class m161216_084622_user_inactive extends Migration
{
    public function up()
    {
        $q = "ALTER TABLE `user`
ADD `inactive` int(11) NOT NULL DEFAULT '0';";
        $this->execute($q);

        $q="ALTER TABLE `user`
ADD INDEX `inactive` (`inactive`);";
        $this->execute($q);


    }

    public function down()
    {
        echo "m161216_084622_user_inactive cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
