<?php

use yii\db\Schema;
use yii\db\Migration;

class m150526_041644_log_user extends Migration
{
    public function up()
    {
        $q = "
        ALTER TABLE `log`
        ADD `user_id` int(11) NULL,
        ADD FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
        COMMENT='';
        ";
        $this->execute($q);
    }

    public function down()
    {
        $q="
        ALTER TABLE `log`
        DROP FOREIGN KEY `log_ibfk_1`
        ";
        $this->execute($q);
        $q="
        ALTER TABLE `log`
        DROP `user_id`,
        COMMENT='';
        ";
        $this->execute($q);

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
