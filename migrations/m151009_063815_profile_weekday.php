<?php

use yii\db\Schema;
use yii\db\Migration;

class m151009_063815_profile_weekday extends Migration
{
    public function up()
    {
        $q = "
          ALTER TABLE `profile`
          ADD `eating_time_start_weekday_1` time NULL,
          ADD `eating_time_end_weekday_1` time NULL AFTER `eating_time_start_weekday_1`,
          ADD `eating_time_start_weekday_2` time NULL AFTER `eating_time_end_weekday_1`,
          ADD `eating_time_end_weekday_2` time NULL AFTER `eating_time_start_weekday_2`,
          ADD `eating_time_start_weekday_3` time NULL AFTER `eating_time_end_weekday_2`,
          ADD `eating_time_end_weekday_3` time NULL AFTER `eating_time_start_weekday_3`,
          ADD `eating_time_start_weekday_4` time NULL AFTER `eating_time_end_weekday_3`,
          ADD `eating_time_end_weekday_4` time NULL AFTER `eating_time_start_weekday_4`,
          ADD `eating_time_start_weekday_5` time NULL AFTER `eating_time_end_weekday_4`,
          ADD `eating_time_end_weekday_5` time NULL AFTER `eating_time_start_weekday_5`,
          COMMENT='';";
        $this->execute($q);
    }

    public function down()
    {
        echo "m151009_063815_profile_weekday cannot be reverted.\n";

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
