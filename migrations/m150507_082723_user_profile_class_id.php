<?php

use yii\db\Schema;
use yii\db\Migration;

class m150507_082723_user_profile_class_id extends Migration
{
    public function up()
    {
        $q = "ALTER TABLE `profile`
ADD `school_class_id` int(11) NULL,
ADD FOREIGN KEY (`school_class_id`) REFERENCES `school_class` (`id`),
COMMENT='';";
        $this->execute($q);
    }

    public function down()
    {
        $q = "ALTER TABLE `profile`
DROP FOREIGN KEY `profile_ibfk_1`";
        $this->execute($q);
        $q = "ALTER TABLE `profile`
DROP `school_class_id`,
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
