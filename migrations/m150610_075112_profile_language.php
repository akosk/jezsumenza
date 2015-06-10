<?php

use yii\db\Schema;
use yii\db\Migration;

class m150610_075112_profile_language extends Migration
{
    public function up()
    {
        $q = "ALTER TABLE `profile`
ADD `language` varchar(255) COLLATE 'utf8_general_ci' NULL,
COMMENT='';";
        $this->execute($q);
    }

    public function down()
    {
        echo "m150610_075112_profile_language cannot be reverted.\n";

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
