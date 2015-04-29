<?php

use yii\db\Schema;
use yii\db\Migration;

class m150428_200053_class extends Migration
{
    public function up()
    {
        $q="CREATE TABLE `school_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_hungarian_ci NOT NULL,
  `eating_time_start` time DEFAULT NULL,
  `eating_time_end` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;";
        $this->execute($q);
    }

    public function down()
    {
        $this->execute('DROP TABLE  `class`');
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
