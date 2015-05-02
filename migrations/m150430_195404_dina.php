<?php

use yii\db\Schema;
use yii\db\Migration;

class m150430_195404_dina extends Migration
{
    public function up()
    {
        $q = "ALTER TABLE `profile`
ADD `dina_id` varchar(255) COLLATE 'utf8_general_ci' NULL,
COMMENT='';";

        $this->execute($q);
    }

    public function down()
    {
        $q = "ALTER TABLE `profile`
DROP `dina_id`,
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
