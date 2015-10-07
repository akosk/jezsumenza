<?php

use yii\db\Schema;
use yii\db\Migration;

class m151007_074637_imported_file extends Migration
{
    public function up()
    {
        $q = "
CREATE TABLE `imported_file` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `filename` varchar(255) NOT NULL,
  `create_time` datetime NOT NULL
) COMMENT='';
";
        $this->execute($q);
    }

    public function down()
    {
        echo "m151007_074637_imported_file cannot be reverted.\n";

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
