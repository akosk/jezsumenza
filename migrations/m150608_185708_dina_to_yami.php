<?php

use yii\db\Schema;
use yii\db\Migration;

class m150608_185708_dina_to_yami extends Migration
{
    public function up()
    {
        $q="ALTER TABLE `profile`
CHANGE `dina_id` `yami_id` varchar(255) COLLATE 'utf8_general_ci' NULL AFTER `bio`,
COMMENT='';";
        $this->execute($q);
    }

    public function down()
    {
        echo "m150608_185708_dina_to_yami cannot be reverted.\n";

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
