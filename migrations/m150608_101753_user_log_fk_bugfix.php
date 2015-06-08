<?php

use yii\db\Schema;
use yii\db\Migration;

class m150608_101753_user_log_fk_bugfix extends Migration
{
    public function up()
    {
        $q="ALTER TABLE `log`
DROP FOREIGN KEY `log_ibfk_2`";
        $this->execute($q);
    }

    public function down()
    {
        echo "m150608_101753_user_log_fk_bugfix cannot be reverted.\n";

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
