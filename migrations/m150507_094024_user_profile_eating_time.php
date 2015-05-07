<?php

use yii\db\Schema;
use yii\db\Migration;

class m150507_094024_user_profile_eating_time extends Migration
{
    public function up()
    {
        $q = "ALTER TABLE `profile`
ADD `eating_time_start` time NULL,
ADD `eating_time_end` time NULL AFTER `eating_time_start`,
COMMENT='';";
        $this->execute($q);
    }

    public function down()
    {
        $q = "ALTER TABLE `profile`
DROP `eating_time_start`,
DROP `eating_time_end`,
COMMENT='';";
        $this->execute($q);
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
