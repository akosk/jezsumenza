<?php

use yii\db\Schema;
use yii\db\Migration;

class m150507_101043_user_profile_barcode extends Migration
{
    public function up()
    {
        $q = "ALTER TABLE `profile`
ADD `barcode` varchar(255) NULL,
COMMENT='';";
        $this->execute($q);
    }

    public function down()
    {
        $q = "ALTER TABLE `profile`
DROP `barcode`,
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
